<?php
session_start();
require "php/dbconnect.php";

// =======================
// VERIFICA LOGIN DO FUNCIONÁRIO
// =======================
if (!isset($_SESSION["funcionario_id"])) {
    header("Location: login.php");
    exit;
}

$funcionario_id = $_SESSION["funcionario_id"];
$empresa_id     = $_SESSION["empresa_id"]; // vem do login do funcionário

// =======================
// BUSCAR OS AGENDAMENTOS DO FUNCIONÁRIO
// =======================
$sql = "
SELECT 
    ag.id,
    ag.data,
    ag.hora,
    ag.servicos,
    cli.nome AS cliente,
    emp.nome AS empresa
FROM agendamentos AS ag
INNER JOIN clientes AS cli ON ag.cliente_id = cli.id
INNER JOIN empresa AS emp ON ag.empresa_id = emp.id
WHERE ag.funcionario_id = $funcionario_id
ORDER BY ag.data ASC, ag.hora ASC
";

$agendamentos = mysqli_query($connect, $sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Funcionário | NailSpot</title>
  <link rel="stylesheet" href="css/funcionario-home.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>
<body>

<header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspot+.png" alt="Logo NailSpot">
      <span class="nome-logo">NailSpot</span>
    </div>
    <nav>
      <ul>
        <li><a href="funcionario-home.php" class="ativo">Home</a></li>
        <li><a href="perfil-funcionario.php">Perfil</a></li>
        <li><a href="logout.php">Sair</a></li>
      </ul>
    </nav>
</header>

<main class="conteudo">

<h1>Meus Atendimentos</h1>

<section class="card">
  <?php if (mysqli_num_rows($agendamentos) == 0): ?>
      <p class="vazio">Nenhum atendimento marcado até o momento.</p>
  <?php else: ?>
      <?php while ($a = mysqli_fetch_assoc($agendamentos)): ?>
        <div class="atendimento">
          <div class="info">
            <p><strong>Cliente:</strong> <?= $a['cliente'] ?></p>
            <p><strong>Serviço:</strong> <?= $a['servicos'] ?></p>
            <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($a['data'])) ?></p>
            <p><strong>Hora:</strong> <?= substr($a['hora'], 0, 5) ?></p>
          </div>
          <div class="acoes">
            <button class="btn-remarcar" data-id="<?= $a['id'] ?>">Remarcar</button>
            <button class="btn-cancelar" data-id="<?= $a['id'] ?>">Cancelar</button>
          </div>
        </div>
      <?php endwhile; ?>
  <?php endif; ?>
</section>

</main>

<!-- MODAL REMARCAR -->
<div id="modal-remarcar" class="modal">
  <div class="modal-conteudo">
    <h3>Remarcar Atendimento</h3>
    <form action="funcionario-remarcar.php" method="POST" id="form-remarcar">
        <input type="hidden" name="id" id="idRemarcar">

        <label for="data">Nova Data:</label>
        <input type="date" name="data" required>

        <label for="hora">Nova Hora:</label>
        <input type="time" name="hora" required>

        <div class="botoes-modal">
          <button type="submit" class="btn-principal">Confirmar</button>
          <button type="button" id="fechar-remarcar" class="btn-cancelar">Voltar</button>
        </div>
    </form>
  </div>
</div>

<!-- MODAL CANCELAR -->
<div id="modal-cancelar" class="modal">
  <div class="modal-conteudo">
    <h3>Cancelar Atendimento</h3>
    <p>Tem certeza que deseja cancelar este atendimento?</p>

    <div class="botoes-modal">
      <a id="confirmar-cancelar" class="btn-principal">Sim</a>
      <button class="btn-cancelar" id="fechar-cancelar">Não</button>
    </div>
  </div>
</div>

<script>
let idSelecionado = null;

// abrir remarcar
document.querySelectorAll(".btn-remarcar").forEach(btn => {
    btn.addEventListener("click", () => {
        idSelecionado = btn.dataset.id;
        document.getElementById("idRemarcar").value = idSelecionado;
        document.getElementById("modal-remarcar").classList.add("mostrar");
    });
});

// abrir cancelar
document.querySelectorAll(".btn-cancelar").forEach(btn => {
    btn.addEventListener("click", () => {
        idSelecionado = btn.dataset.id;
        document.getElementById("confirmar-cancelar").href =
          "funcionario-cancelar.php?id=" + idSelecionado;

        document.getElementById("modal-cancelar").classList.add("mostrar");
    });
});

// fechar modais
document.getElementById("fechar-remarcar").onclick = () =>
  document.getElementById("modal-remarcar").classList.remove("mostrar");

document.getElementById("fechar-cancelar").onclick = () =>
  document.getElementById("modal-cancelar").classList.remove("mostrar");
</script>

<footer class="rodape">
  <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
</footer>

</body>
</html>
