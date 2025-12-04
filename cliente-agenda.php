<?php
// DEBUG (apenas em DEV; remova em produção)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// =======================
// VERIFICA LOGIN
// =======================
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = intval($_SESSION["cliente_id"]); // força inteiro

// =======================
// BUSCAR AGENDAMENTOS DO CLIENTE (Prepared Statement)
// =======================
// Usar prepared statement evita problemas se o cliente_id tivesse vindo de fonte externa.
$sql = "
    SELECT 
        ag.id,
        ag.data,
        ag.hora,
        ag.servicos,
        ag.status,
        emp.nome AS empresa,
        func.nome AS profissional
    FROM agendamentos AS ag
    INNER JOIN empresa AS emp ON ag.empresa_id = emp.id
    LEFT JOIN funcionarios AS func ON ag.funcionario_id = func.id
    WHERE ag.cliente_id = ?
    ORDER BY ag.data ASC
";

$eventos = [];

// Preparar e executar
if ($stmt = mysqli_prepare($connect, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    if (mysqli_stmt_execute($stmt)) {
        $res = mysqli_stmt_get_result($stmt);
        if ($res !== false) {
            while ($a = mysqli_fetch_assoc($res)) {

                // proteger valores que virão para o HTML (evita quebra de JSON/JS)
                $empresa = htmlspecialchars($a['empresa'] ?? ' — ');
                $profissional = htmlspecialchars($a['profissional'] ?? ' — ');
                $servicos = htmlspecialchars($a['servicos'] ?? ' — ');
                $status = htmlspecialchars($a['status'] ?? ' — ');
                $hora = $a['hora'] ?? '';

                // Data: validar antes de converter
                $dataRaw = $a['data'] ?? null;
                if ($dataRaw && strtotime($dataRaw) !== false) {
                    // formato ISO YYYY-MM-DD (mais compatível)
                    $dataFormatada = date("Y-m-d", strtotime($dataRaw));
                } else {
                    // pula registro inválido ou define uma data fallback
                    continue; // pula este agendamento
                }

                // montar descrição (contendo HTML) — como contém HTML, mantivemos tags,
                // mas os valores inseridos já foram escapados com htmlspecialchars acima.
                $descricao = "
                    <div class='caixa-servico'>
                      <h3>Agendamento</h3>
                      <p><strong>Local:</strong> {$empresa}</p>
                      <p><strong>Horário:</strong> {$hora}</p>
                      <p><strong>Serviço:</strong> {$servicos}</p>
                      <p><strong>Profissional:</strong> {$profissional}</p>
                      <p><strong>Status:</strong> {$status}</p>
                      <div class='botoes-servico'>
                        <button class='btn-remarcar' data-id='{$a['id']}'>Remarcar</button>
                        <button class='btn-excluir' data-id='{$a['id']}'>Cancelar</button>
                      </div>
                    </div>
                ";

                $eventos[] = [
                    "id" => "ag-" . $a['id'],
                    "name" => "Agendamento",
                    "date" => $dataFormatada,
                    "type" => "event",
                    "description" => $descricao
                ];
            }
            mysqli_free_result($res);
        } else {
            // erro ao obter resultado
            error_log("Erro mysqli_stmt_get_result: " . mysqli_error($connect));
        }
    } else {
        error_log("Erro ao executar statement: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    // erro ao preparar
    error_log("Erro ao preparar SQL: " . mysqli_error($connect));
}

// ok: $eventos pronto para json_encode
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