<?php
  
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// =======================
// 1. VERIFICA LOGIN
// =======================
if(!isset($_SESSION['cliente_id'])){
    // Caso não esteja logado, redireciona
    header("Location: login.php");
    exit;
}

// Verifica se o ID veio pela URL
if (!isset($_GET['id'])) {
    die("<h2>Empresa não encontrada.</h2>");
}

$id = intval($_GET['id']);

// Busca os dados da empresa
$sql = "SELECT nome, endereco, telefone, cep, horario FROM empresa WHERE id = $id LIMIT 1";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) == 0) {
    die("<h2>Empresa não encontrada.</h2>");
}

$empresa = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato - <?= htmlspecialchars($empresa['nome']) ?></title>
  <link rel="stylesheet" href="css/cliente-contato.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="Logo Nailspot">
      <span class="nome-logo">NailSpot</span>
    </div>

    <nav>
      <ul>
        <li><a href="cliente-servicos.php">Serviços</a></li>
        <li><a href="cliente-agenda.php">Agenda</a></li>
        <li><a href="cliente-perfil.php">Perfil</a></li>
        <li><a href="login.php">Sair</a></li>
      </ul>
    </nav>
</header>

<main class="container">
    <h1>Contato - <?= htmlspecialchars($empresa['nome']) ?></h1>
    <p class="subtitulo">Entre em contato com o estabelecimento</p>

    <section class="conteudo">

      <!-- CARD LADO ESQUERDO - INFORMAÇÕES -->
      <div class="card-contato">

        <h2><?= htmlspecialchars($empresa['nome']) ?></h2>

        

        <div class="info">

          <div class="info-item">
            <span class="icon">📍</span>
            <div>
              <strong>Endereço</strong>
              <p><?= htmlspecialchars($empresa['endereco']) ?><br>
              CEP: <?= htmlspecialchars($empresa['cep']) ?></p>
            </div>
          </div>

          <div class="info-item">
            <span class="icon">📞</span>
            <div>
              <strong>Telefone</strong>
              <p><?= htmlspecialchars($empresa['telefone']) ?><br>
              <small>WhatsApp disponível</small></p>
            </div>
          </div>

          <div class="info-item">
            <span class="icon">⏰</span>
            <div>
              <strong>Horário de Funcionamento</strong>
              <p><?= htmlspecialchars($empresa['horario']) ?></p>
            </div>
          </div>

        </div>
      </div>

      <!-- CARD DIREITO - MENSAGEM -->
      <div class="card-mensagem">
        <h2>Enviar Mensagem</h2>

        <label>Seu Nome</label>
        <input type="text" placeholder="Maria Silva">

        <label>Seu E-mail</label>
        <input type="email" placeholder="meuemail@gmail.com">

        <label>Mensagem</label>
        <textarea placeholder="Digite sua mensagem aqui..."></textarea>

        <div class="botoes">
          <a href="cliente-servicos.php" class="botao branco">Voltar</a>
          <button class="botao rosa">Enviar Mensagem</button>
        </div>

        <div class="dica">
          <strong>Dica:</strong> Para atendimento mais rápido, entre em contato via WhatsApp.
        </div>
      </div>

    </section>
  </main>

<footer class="rodape">
  <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
</footer>

</body>
</html>