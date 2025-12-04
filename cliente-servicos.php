<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// =======================
// 1. VERIFICA LOGIN
// =======================
if (!isset($_SESSION['cliente_id'])) {
  header("Location: login.php");
  exit;
}

// NOVA CONSULTA COM JOIN DO HORÁRIO
$sql = "SELECT 
            empresa.id,
            empresa.nome,
            empresa.telefone,
            empresa.endereco,
            empresa.preco,
            empresa.servicos,
            ehf.abertura,
            ehf.fechamento
        FROM empresa
        LEFT JOIN empresa_horario_funcionamento AS ehf
            ON empresa.id = ehf.empresa_id
        ORDER BY empresa.id DESC";

$empresas = mysqli_query($connect, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NailSpot | Serviços</title>
  <link rel="stylesheet" href="css/cliente-servico.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="">
      <span class="nomeLogo">NailSpot</span>
    </div>

    <nav>
      <ul>
        <li><a href="cliente-servicos.php" class="ativo">Serviços</a></li>
        <li><a href="cliente-agenda.php">Agenda</a></li>
        <li><a href="cliente-perfil.php">Perfil</a></li>
        <li><a href="login.php">Sair</a></li>
      </ul>
    </nav>
  </header>

  <main class="container">

    <h1>Nossos Serviços</h1>
    <p class="subtitle">Escolha o serviço desejado para agendar ou entrar em contato</p>

    <div class="cards-grid">

      <?php while ($e = mysqli_fetch_assoc($empresas)): ?>

        <?php
        $id = $e['id'];

        // Tags (CSV)
        $tags = [];

        if (isset($e['servicos']) && trim($e['servicos']) !== "") {
          $tags = array_filter(array_map('trim', explode(",", $e['servicos'])));
        }

        // NOVO HORÁRIO
        if (!empty($e['abertura']) && !empty($e['fechamento'])) {
          $horario = $e['abertura'] . " às " . $e['fechamento'];
        } else {
          $horario = "Horário não informado";
        }

        // Preço
        $preco = $e['preco'] ? "R$ " . number_format($e['preco'], 2, ',', '.') : "Consulte valores";
        ?>

        <article class="card-servico">



          <div class="card-body">

            <h3><?= htmlspecialchars($e['nome']) ?></h3>

            <p><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($e['endereco']) ?></p>
            <p><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($e['telefone']) ?></p>

            <p><i class="fa-regular fa-clock"></i> <?= $horario ?></p>

            <div class="tags">
              <?php if (!empty($tags)): ?>
                <?php foreach ($tags as $t): ?>
                  <span><?= htmlspecialchars($t) ?></span>
                <?php endforeach; ?>
              <?php else: ?>
                <span class="sem-servicos">Serviços não informados</span>
              <?php endif; ?>
            
            </div>

            <span class="preco"><?= $preco ?></span>

            <div class="botoes">
              <button class="botao rosa"
                onclick="window.location.href='cliente-agendamento.php?id=<?= $id ?>'">Agendar</button>
              <button class="botao branco"
                onclick="window.location.href='cliente-contato.php?id=<?= $id ?>'">Contato</button>
            </div>

          </div>
        </article>

      <?php endwhile; ?>

    </div>

  </main>

  <footer class="rodape">
    © 2025 NailSpot - Seu momento de beleza e bem-estar
  </footer>

</body>

</html>