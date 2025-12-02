<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// =======================
// VERIFICA LOGIN
// =======================
if(!isset($_SESSION['cliente_id'])){
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION["cliente_id"];

// =======================
// BUSCAR AGENDAMENTOS DO CLIENTE
// =======================
$sql = "SELECT 
            ag.id,
            ag.data,
            ag.hora,
            ag.servicos,
            ag.status,
            emp.nome AS empresa,
            func.nome AS profissional
        FROM agendamentos AS ag
        INNER JOIN empresa AS emp ON ag.empresa_id = emp.id
        INNER JOIN funcionarios AS func ON ag.funcionario_id = func.id
        WHERE ag.cliente_id = $cliente_id
        ORDER BY ag.data ASC";

$rs = mysqli_query($connect, $sql);

// ARRAY DE EVENTOS PARA O CALENDÁRIO
$eventos = [];

while ($a = mysqli_fetch_assoc($rs)) {

    // Formato MM/DD/YYYY para o calendário
    $dataFormatada = date("m/d/Y", strtotime($a["data"]));

    $eventos[] = [
        "id" => "ag-" . $a["id"],
        "name" => "Agendamento",
        "date" => $dataFormatada,
        "type" => "event",
        "description" => "
            <div class='caixa-servico'>
              <h3>Agendamento</h3>
              <p><strong>Local:</strong> {$a['empresa']}</p>
              <p><strong>Horário:</strong> {$a['hora']}</p>
              <p><strong>Serviço:</strong> {$a['servicos']}</p>
              <p><strong>Profissional:</strong> {$a['profissional']}</p>
              <p><strong>Status:</strong> {$a['status']}</p>

              <div class='botoes-servico'>
                <button class='btn-remarcar' data-id='{$a['id']}'>Remarcar</button>
                <button class='btn-excluir' data-id='{$a['id']}'>Cancelar</button>
              </div>
            </div>
        "
    ];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NailSpot | Agenda</title>
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
  <link rel="stylesheet" href="css/cliente-agenda.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css" />
</head>

<body>

<header class="navbar">
  <div class="logo">
    <img src="img/LogoNailspotofc.png" alt="Logo NailSpot" />
    <span class="nome-logo">NailSpot</span>
  </div>

  <nav>
    <ul>
      <li><a href="cliente-servicos.php">Serviços</a></li>
      <li><a href="cliente-agenda.php" class="ativo">Agenda</a></li>
      <li><a href="cliente-perfil.php">Perfil</a></li>
      <li><a href="login.php">Sair</a></li>
    </ul>
  </nav>
</header>

<h1>Minha Agenda</h1>

<div class="card">
  <div id="evoCalendar"></div>
</div>

<!-- MODAL REMARCAR -->
<div id="modalRemarcar" class="modal">
  <div class="modal-content">
    <span class="fechar">&times;</span>
    <h2>Remarcar Agendamento</h2>

    <form id="formRemarcar">
      <input type="hidden" name="id" id="idRemarcar">

      <label>Nova Data:</label>
      <input type="date" name="data" required>

      <label>Novo Horário:</label>
      <input type="time" name="hora" required>

      <div class="botoes-modal">
        <button type="submit" class="btn-remarcar">Confirmar</button>
        <button type="button" id="cancelarModal" class="btn-cancelar">Cancelar</button>
      </div>
    </form>

  </div>
</div>

<footer class="rodape">
  <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/js/evo-calendar.min.js"></script>

<script>
$(document).ready(function() {

  // Eventos vindo do PHP
  let eventos = <?= json_encode($eventos, JSON_UNESCAPED_UNICODE) ?>;

  $('#evoCalendar').evoCalendar({
      theme: 'Default',
      language: 'pt',
      eventDisplayDefault: true,
      eventListToggler: true,
      sidebarToggler: true,
      todayHighlight: true,
      calendarEvents: eventos
  });

  // REMARCAR ----------------------------
  $(document).on('click', '.btn-remarcar', function() {
      let id = $(this).data('id');
      $('#idRemarcar').val(id);
      $('#modalRemarcar').fadeIn();
  });

  $('.fechar, #cancelarModal').on('click', function() {
      $('#modalRemarcar').fadeOut();
  });

  $('#formRemarcar').on('submit', function(e) {
      e.preventDefault();
      alert("Remarcação enviada (aqui você cria o PHP para salvar)");
      $('#modalRemarcar').fadeOut();
  });

  // CANCELAR ----------------------------
  $(document).on('click', '.btn-excluir', function() {
      if (confirm("Deseja realmente cancelar este agendamento?")) {
          let id = $(this).data('id');
          window.location.href = "cliente-cancelar.php?id=" + id;
      }
  });

});
</script>

</body>
</html>