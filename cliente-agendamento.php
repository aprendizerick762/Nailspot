<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// =========================
// 0. Verifica login
// =========================
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// =========================
// 1. PROCESSAMENTO DO FORM (POST)
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // coletar + sanitizar entradas
    $cliente_id    = intval($_SESSION['cliente_id']);
    $empresa_id    = isset($_POST['empresa_id']) ? intval($_POST['empresa_id']) : 0;
    $funcionario   = isset($_POST['profissional']) ? intval($_POST['profissional']) : 0;
    $data          = isset($_POST['data']) ? $_POST['data'] : '';
    $hora          = isset($_POST['hora']) ? $_POST['hora'] : '';
    $cliente_nome  = isset($_POST['cliente_nome']) ? trim($_POST['cliente_nome']) : '';
    $cliente_email = isset($_POST['cliente_email']) ? trim($_POST['cliente_email']) : '';

    // serviços -> array -> string (se houver)
    $servicos = isset($_POST['servico']) && is_array($_POST['servico']) ? implode(", ", array_map('trim', $_POST['servico'])) : '';

    // validações básicas
    if ($empresa_id <= 0) {
        $_SESSION['mensagem'] = "Empresa inválida.";
        header("Location: cliente-servicos.php");
        exit;
    }

    if (empty($servicos)) {
        $_SESSION['mensagem'] = "Selecione pelo menos um serviço.";
        header("Location: cliente-agenda.php?id=" . $empresa_id);
        exit;
    }



    if (empty($data)) {
        $_SESSION['mensagem'] = "Selecione a data do agendamento.";
        header("Location: cliente-agenda.php?id=" . $empresa_id);
        exit;
    }

    if (empty($cliente_nome) || empty($cliente_email)) {
        $_SESSION['mensagem'] = "Preencha seus dados.";
        header("Location: cliente-agenda.php?id=" . $empresa_id);
        exit;
    }

    // Inserir no banco - prepared statement
    $stmt = mysqli_prepare($connect, "
        INSERT INTO agendamentos 
        (cliente_id, empresa_id, funcionario_id, servicos, data, hora, cliente_nome, cliente_email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        $_SESSION['mensagem'] = "Erro no banco: " . mysqli_error($connect);
        header("Location: cliente-agenda.php?id=" . $empresa_id);
        exit;
    }

    // bind params e executar
    mysqli_stmt_bind_param($stmt, "iiisssss",
        $cliente_id,
        $empresa_id,
        $funcionario,
        $servicos,
        $data,
        $hora,
        $cliente_nome,
        $cliente_email
    );

    $ok = mysqli_stmt_execute($stmt);
    if ($ok) {
        $_SESSION['mensagem'] = "Agendamento realizado com sucesso!";
        mysqli_stmt_close($stmt);

        // Redireciona para a agenda do cliente
        header("Location: cliente-agenda.php?id=" . $empresa_id);
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao salvar agendamento: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        header("Location: cliente-agenda.php?id=" . $empresa_id);
        exit;
    }
} 

// =========================
// 2. EXIBIÇÃO DO FORM (GET)
// =========================
// Verifica empresa via GET id
if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = "Nenhuma empresa selecionada!";
    header("Location: cliente-servicos.php");
    exit;
}

$empresa_id = intval($_GET['id']);

// Buscar empresa
$sqlE = "SELECT * FROM empresa WHERE id = ? LIMIT 1";
$stmtE = mysqli_prepare($connect, $sqlE);
mysqli_stmt_bind_param($stmtE, "i", $empresa_id);
mysqli_stmt_execute($stmtE);
$resE = mysqli_stmt_get_result($stmtE);
$empresa = mysqli_fetch_assoc($resE);
mysqli_stmt_close($stmtE);

if (!$empresa) {
    $_SESSION['mensagem'] = "Empresa não encontrada!";
    header("Location: cliente-servicos.php");
    exit;
}

// serviços (CSV -> array)
$servicos = [];
if (!empty($empresa['servicos'])) {
    $servicos = array_map('trim', explode(",", $empresa['servicos']));
}

// funcionários da empresa
$sqlF = "SELECT * FROM funcionarios WHERE empresa_id = ? ORDER BY nome ASC";
$stmtF = mysqli_prepare($connect, $sqlF);
mysqli_stmt_bind_param($stmtF, "i", $empresa_id);
mysqli_stmt_execute($stmtF);
$funcionarios_res = mysqli_stmt_get_result($stmtF);
mysqli_stmt_close($stmtF);

// horários disponíveis para agendamento
$sqlH = "SELECT * FROM empresa_horarios_disponiveis WHERE empresa_id = ? ORDER BY hora_inicio ASC";
$stmtH = mysqli_prepare($connect, $sqlH);
mysqli_stmt_bind_param($stmtH, "i", $empresa_id);
mysqli_stmt_execute($stmtH);
$horarios_res = mysqli_stmt_get_result($stmtH);
mysqli_stmt_close($stmtH);

// Preencher nome/email do cliente a partir da sessão ou do BD
$cliente_nome_sess = $_SESSION['cliente_nome'] ?? '';
$cliente_email_sess = $_SESSION['cliente_email'] ?? '';


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Novo Agendamento - NailSpot</title>
  <link rel="stylesheet" href="css/cliente-agendamento.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>
<body>
<header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="">
      <span class="nome-logo">NailSpot</span>
    </div>
    <nav>
      <ul>
        <li><a href="cliente-servicos.php" class="active">Serviços</a></li>
        <li><a href="cliente-agenda.php">Agenda</a></li>
        <li><a href="cliente-perfil.php">Perfil</a></li>
        <li><a href="login.php">Sair</a></li>
      </ul>
    </nav>
</header>

<main>
  <section class="container-agendamento">
    <h2>Novo Agendamento</h2>
    <p class="subtitle"><?= htmlspecialchars($empresa['nome']) ?></p>

    <!-- mostra mensagem (se houver) -->
    <?php if(isset($_SESSION['mensagem'])): ?>
      <p class="alert"><?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></p>
    <?php endif; ?>

    <form action="cliente-agendamento.php" method="POST">
      <input type="hidden" name="empresa_id" value="<?= $empresa_id ?>">

      <!-- PROFISSIONAIS -->
      <h3>Escolha a Profissional</h3>
      <div class="profissionais">
        <?php if ($funcionarios_res && mysqli_num_rows($funcionarios_res) > 0): ?>
          <?php while ($f = mysqli_fetch_assoc($funcionarios_res)): ?>
            <label class="profissional">
              <input type="radio" name="profissional" value="<?= $f['id'] ?>" required>
              <div>
                <strong><?= htmlspecialchars($f['nome']) ?></strong><br>
                <span><?= htmlspecialchars(ucfirst($f['funcao'])) ?></span>
              </div>
            </label>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="erro">Nenhum funcionário cadastrado!</p>
        <?php endif; ?>
      </div>

      <!-- SERVIÇOS -->
      <h3>Selecione o Serviço</h3>
      <div class="servicos">
        <?php if (!empty($servicos)): ?>
          <?php foreach ($servicos as $s): ?>
            <label class="servico">
              <div>
                <input type="checkbox" name="servico[]" value="<?= htmlspecialchars($s) ?>">
                <?= htmlspecialchars($s) ?>
              </div>
            </label>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="erro">Serviços não informados pela empresa.</p>
        <?php endif; ?>
      </div>

      <!-- DATA -->
      <h3>Data do Agendamento</h3>
      <input type="date" name="data" required>

      <!-- HORÁRIOS -->
      <h3>Horário Disponível</h3>
      <div class="horarios">
        <?php if ($horarios_res && mysqli_num_rows($horarios_res) > 0): ?>
          <?php while ($h = mysqli_fetch_assoc($horarios_res)): ?>
            <button type="button" onclick="selecionarHorario(this)" data-hora="<?= htmlspecialchars($h['hora_inicio']) ?>">
              <?= substr($h['hora_inicio'], 0, 5) ?>
            </button>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="erro">Horários não configurados.</p>
        <?php endif; ?>
      </div>

      <input type="hidden" name="hora" id="horaInput">

      <!-- DADOS DO CLIENTE -->
      <h3>Seus Dados</h3>
      <input type="text" name="cliente_nome" value="<?= htmlspecialchars($cliente_nome_sess) ?>" required>
      <input type="email" name="cliente_email" value="<?= htmlspecialchars($cliente_email_sess) ?>" required>

      <div class="acoes">
        <a href="cliente-servicos.php" class="cancelar">Cancelar</a>
        <button type="submit" class="confirmar" >Confirmar Agendamento</button>
      </div>
    </form>
  </section>
</main>

<footer class="rodape">
  <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
</footer>

<script>
function selecionarHorario(btn) {
  document.querySelectorAll(".horarios button").forEach(b => b.classList.remove("ativo"));
  btn.classList.add("ativo");
  document.getElementById("horaInput").value = btn.dataset.hora;
}
</script>

</body>
</html>