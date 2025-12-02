<?php
session_start();
require "php/dbconnect.php";

/* Ativar erros para debug (remover depois) */
ini_set("display_errors", 1);
error_reporting(E_ALL);

if (!isset($_SESSION['empresa_id'])) {
    header("Location: login.php");
    exit;
}

$empresa_id = intval($_SESSION['empresa_id']);


// ======================================================
// 1. ADICIONAR FUNCIONÁRIO
// ======================================================
if (isset($_POST['add_funcionario'])) {
    $nome = mysqli_real_escape_string($connect, $_POST['nome']);
    $cpf = mysqli_real_escape_string($connect, $_POST['cpf']);
    $telefone = mysqli_real_escape_string($connect, $_POST['telefone']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $funcao = mysqli_real_escape_string($connect, $_POST['funcao']);

    $sql = "INSERT INTO funcionarios 
            (empresa_id, nome, cpf, telefone, email, funcao)
            VALUES ($empresa_id, '$nome', '$cpf', '$telefone', '$email', '$funcao')";

    if (!mysqli_query($connect, $sql)) {
        die("Erro ao adicionar funcionário: " . mysqli_error($connect));
    }

    header("Location: empresa-dashboard.php");
    exit;
}


// ======================================================
// 2. EXCLUIR FUNCIONÁRIO
// ======================================================
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);

    $sql = "DELETE FROM funcionarios WHERE id = $id AND empresa_id = $empresa_id";

    if (!mysqli_query($connect, $sql)) {
        die("Erro ao excluir funcionário: " . mysqli_error($connect));
    }

    header("Location: empresa-dashboard.php");
    exit;
}


// ======================================================
// 3. SALVAR HORÁRIO DE FUNCIONAMENTO
// ======================================================
if (isset($_POST['salvar_funcionamento'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    $sql = "INSERT INTO empresa_horario_funcionamento (empresa_id, abertura, fechamento)
            VALUES ($empresa_id, '$inicio', '$fim')
            ON DUPLICATE KEY UPDATE abertura='$inicio', fechamento='$fim'";

    if (!mysqli_query($connect, $sql)) {
        die("Erro ao salvar horário: " . mysqli_error($connect));
    }

    header("Location: empresa-dashboard.php");
    exit;
}


// ======================================================
// 4. SALVAR HORÁRIOS DISPONÍVEIS PARA AGENDAMENTO
// ======================================================
if (isset($_POST['add_horario'])) {
    $dia = mysqli_real_escape_string($connect, $_POST['dia']);
    $horaIni = $_POST['hora_inicio'];
    $horaFim = $_POST['hora_fim'];

    $sql = "INSERT INTO empresa_horarios_disponiveis
            (empresa_id, dia_semana, hora_inicio, hora_fim)
            VALUES ($empresa_id, '$dia', '$horaIni', '$horaFim')";

    if (!mysqli_query($connect, $sql)) {
        die("Erro ao adicionar horário: " . mysqli_error($connect));
    }

    header("Location: empresa-dashboard.php");
    exit;
}


// ======================================================
// 5. BUSCAR DADOS PARA EXIBIÇÃO
// ======================================================

$funcionarios = mysqli_query($connect, 
    "SELECT * FROM funcionarios WHERE empresa_id = $empresa_id"
);

if (!$funcionarios) {
    die("Erro ao buscar funcionários: " . mysqli_error($connect));
}

$funcionamentoSQL = mysqli_query($connect, 
    "SELECT * FROM empresa_horario_funcionamento WHERE empresa_id = $empresa_id LIMIT 1"
);

if (!$funcionamentoSQL) {
    die("Erro ao buscar horário de funcionamento: " . mysqli_error($connect));
}

$funcionamento = mysqli_fetch_assoc($funcionamentoSQL);

$horarios = mysqli_query($connect, 
    "SELECT * FROM empresa_horarios_disponiveis WHERE empresa_id = $empresa_id ORDER BY id DESC"
);

if (!$horarios) {
    die("Erro ao buscar horários disponíveis: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard da Empresa | NailSpot</title>
  <link rel="stylesheet" href="css/empresa-dashboard.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>
<body>

  <!-- CABEÇALHO -->
  <header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="Logo NailSpot">
      <span class="nome-logo">NailSpot</span>
    </div>
    <nav>
      <ul>
        <li><a href="empresa-dashboard.php" class="ativo">Dashboard</a></li>
        <li><a href="empresa-perfil.php">Perfil</a></li>
        <li><a href="login.php">Sair</a></li>
      </ul>
    </nav>
  </header>


  <!-- CONTEÚDO PRINCIPAL -->
  <main class="conteudo">
    <h1>Dashboard da Empresa</h1>


    <!-- ADICIONAR FUNCIONÁRIO -->
    <section class="card">
      <h2>Adicionar Funcionário</h2>

      <form method="POST">
        <div class="form-group">
          <label>Nome Completo:</label>
          <input type="text" name="nome" required>
        </div>

        <div class="form-group">
          <label>CPF:</label>
          <input type="text" name="cpf" required>
        </div>

        <div class="form-group">
          <label>Telefone:</label>
          <input type="text" name="telefone" required>
        </div>

        <div class="form-group">
          <label>E-mail:</label>
          <input type="email" name="email" required>
        </div>

        <div class="form-group">
          <label>Função:</label>
          <select name="funcao" required>
            <option value="">Selecione</option>
            <option value="manicure">Manicure</option>
            <option value="pedicure">Pedicure</option>
            <option value="ambos">Ambos</option>
          </select>
        </div>

        <button type="submit" name="add_funcionario" class="btn-principal">
          Adicionar Funcionário
        </button>
      </form>
    </section>


    <!-- LISTA FUNCIONÁRIOS -->
    <section class="card">
      <h2>Funcionários Cadastrados</h2>
      <table id="tabela-funcionarios">
        <thead>
          <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Função</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          <?php while ($f = mysqli_fetch_assoc($funcionarios)): ?>
            <tr>
              <td><?= $f['nome'] ?></td>
              <td><?= $f['cpf'] ?></td>
              <td><?= $f['telefone'] ?></td>
              <td><?= $f['email'] ?></td>
              <td><?= ucfirst($f['funcao']) ?></td>
              <td>
                <a href="empresa-dashboard.php?del=<?= $f['id'] ?>" 
                   onclick="return confirm('Excluir funcionário?')" 
                   class="btn-excluir">Excluir</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>


    <!-- HORÁRIO DE FUNCIONAMENTO -->
    <section class="card">
      <h2>Definir Horário de Funcionamento</h2>

      <form method="POST">
        <div class="form-group horarios">
          <div>
            <label>Abertura:</label>
            <input type="time" name="inicio" value="<?= $funcionamento['abertura'] ?? '' ?>">
          </div>

          <div>
            <label>Fechamento:</label>
            <input type="time" name="fim" value="<?= $funcionamento['fechamento'] ?? '' ?>">
          </div>
        </div>

        <button type="submit" name="salvar_funcionamento" class="btn-principal">
          Salvar
        </button>
      </form>
    </section>


    <!-- HORÁRIOS DISPONÍVEIS -->
    <section class="card">
      <h2>Horários Disponíveis para Agendamento</h2>

      <form method="POST">
        <div class="form-group">
          <label>Dia da Semana:</label>
          <select name="dia" required>
            <option value="">Selecione</option>
            <option>Segunda-feira</option>
            <option>Terça-feira</option>
            <option>Quarta-feira</option>
            <option>Quinta-feira</option>
            <option>Sexta-feira</option>
            <option>Sábado</option>
          </select>
        </div>

        <div class="form-group horarios">
          <div>
            <label>Início:</label>
            <input type="time" name="hora_inicio" required>
          </div>

          <div>
            <label>Fim:</label>
            <input type="time" name="hora_fim" required>
          </div>
        </div>

        <button type="submit" name="add_horario" class="btn-principal">
          Adicionar Horário
        </button>
      </form>

      <ul id="lista-horarios">
        <?php while ($h = mysqli_fetch_assoc($horarios)): ?>
          <li><?= $h['dia_semana'] ?>: <?= $h['hora_inicio'] ?> às <?= $h['hora_fim'] ?></li>
        <?php endwhile; ?>
      </ul>
    </section>

  </main>

  <footer class="rodape">
    © 2025 NailSpot. Todos os direitos reservados.
  </footer>

</body>
</html>