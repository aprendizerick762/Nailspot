<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NailSpot | Agenda</title>
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
  <link rel="stylesheet" href="css/cliente-agenda.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css"
  />
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="Logo NailSpot" />
      <span class="nome-logo">NailSpot</span>
    </div>
    <nav>
      <ul>
        <li><a href="cliente-servicos.html">Serviços</a></li>
        <li><a href="cliente-agenda.html" class="ativo">Agenda</a></li>
        <li><a href="cliente-perfil.html">Perfil</a></li>
      </ul>
    </nav>
  </header>

  <h1>Nossos Serviços</h1>

  <div class="card">
    <div id="evoCalendar"></div>
  </div>

  <!-- Modal de Remarcação -->
  <div id="modalRemarcar" class="modal">
    <div class="modal-content">
      <span class="fechar">&times;</span>
      <h2>Remarcar Agendamento</h2>
      <label for="novaData">Nova Data:</label>
      <input type="date" id="novaData" />
      
      <label for="novoHorario">Novo Horário:</label>
      <select id="novoHorario">
        <option value="">Selecione um horário</option>
        <option>09:00</option>
        <option>10:30</option>
        <option>13:00</option>
        <option>14:30</option>
        <option>16:00</option>
        <option>17:30</option>
      </select>

      <div class="botoes-modal">
        <button id="confirmarRemarcacao" class="btn-remarcar">Confirmar</button>
        <button id="cancelarModal" class="btn-cancelar">Cancelar</button>
      </div>
    </div>
  </div>

  <footer class="rodape">
    <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/js/evo-calendar.min.js"></script>

  <script>
    $(document).ready(function() {
      // Inicializa o calendário
      $('#evoCalendar').evoCalendar({
        theme: 'Default',
        format: 'mm/dd/yyyy',
        titleFormat: 'MM yyyy',
        eventHeaderFormat: 'MM d, yyyy',
        firstDayOfWeek: 0,
        language: 'pt',
        todayHighlight: true,
        sidebarDisplayDefault: false,
        sidebarToggler: true,
        eventListToggler: true
      });

      // Adiciona evento com os dados do serviço
      $('#evoCalendar').evoCalendar('addCalendarEvent', [
        {
          id: 'evento-servico-1',
          name: 'Atendimento NailSpot',
          date: '11/18/2025',
          type: 'appointment',
          description: `
            <div class="caixa-servico">
              <h3>Atendimento NailSpot</h3>
              <p><strong>Local:</strong> NailSpot Studio - Unidade Centro</p>
              <p><strong>Horário:</strong> 14:30</p>
              <p><strong>Serviço:</strong> Manicure</p>
              <p><strong>Profissional:</strong> Ana Souza</p>
              <div class="botoes-servico">
                <button class="btn-remarcar">Remarcar</button>
                <button class="btn-cancelar">Cancelar</button>
              </div>
            </div>
          `
        }
      ]);

      // Abrir o modal ao clicar em "Remarcar"
      $(document).on('click', '.btn-remarcar', function() {
        $('#modalRemarcar').fadeIn();
      });

      // Fechar o modal
      $('.fechar, #cancelarModal').on('click', function() {
        $('#modalRemarcar').fadeOut();
      });

      // Confirmar remarcação
      $('#confirmarRemarcacao').on('click', function() {
        const novaData = $('#novaData').val();
        const novoHorario = $('#novoHorario').val();

        if (!novaData || !novoHorario) {
          alert('Por favor, selecione uma nova data e horário.');
          return;
        }

        alert(`Agendamento remarcado para ${novaData} às ${novoHorario}.`);
        $('#modalRemarcar').fadeOut();
      });

      // Cancelar agendamento
      $(document).on('click', '.btn-cancelar', function() {
        if (confirm('Tem certeza que deseja cancelar este agendamento?')) {
          alert('Agendamento cancelado.');
        }
      });
    });
  </script>
</body>
</html>