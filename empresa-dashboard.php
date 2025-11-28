

<!DOCTYPE html>
<html lang="en">
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
      <img src="img/LogoNailspot+.png" alt="Logo NailSpot">
      <span class="nome-logo">NailSpot</span>
    </div>
    <nav>
      <ul>
        <li><a href="empresa-dashboard.php" class="ativo">Dashboard</a></li>
        <li><a href="empresa-perfil.php">Perfil</a></li>
        <li><a href="#">Sair</a></li>
      </ul>
    </nav>
  </header>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="conteudo">
    <h1>Dashboard da Empresa</h1>

    <!-- ADICIONAR FUNCIONÁRIO -->
    <section class="card">
      <h2>Adicionar Funcionário</h2>
      <form id="form-funcionario">
        <div class="form-group">
          <label for="nome">Nome Completo:</label>
          <input type="text" id="nome" required>
        </div>
        <div class="form-group">
          <label for="cpf">CPF:</label>
          <input type="text" id="cpf" required>
        </div>
        <div class="form-group">
          <label for="telefone">Telefone:</label>
          <input type="text" id="telefone" required>
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" id="email" required>
        </div>

        <div class="form-group">
          <label for="cargo">Função:</label>
          <select id="cargo" required>
            <option value="">Selecione</option>
            <option value="manicure">Manicure</option>
            <option value="pedicure">Pedicure</option>
            <option value="ambos">Ambos</option>
          </select>
        </div>

        <button type="submit" class="btn-principal">Adicionar Funcionário</button>
      </form>
    </section>

    <!-- LISTA DE FUNCIONÁRIOS -->
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
          <tr>
            <td>Maria Silva</td>
            <td>123.456.789-00</td>
            <td>(11) 99999-8888</td>
            <td>maria@nailspot.com</td>
            <td>Manicure</td>
            <td><button class="btn-excluir" onclick="confirmarExclusao()">Excluir</button></td>
          </tr>
          <tr>
            <td>Ana Souza</td>
            <td>987.654.321-00</td>
            <td>(11) 98888-7777</td>
            <td>ana@nailspot.com</td>
            <td>Ambos</td>
            <td><button class="btn-excluir" onclick="confirmarExclusao()">Excluir</button></td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- HORÁRIOS DE FUNCIONAMENTO -->
    <section class="card">
      <h2>Definir Horário de Funcionamento</h2>
      <div class="form-group horarios">
        <div>
          <label for="inicio">Abertura:</label>
          <input type="time" id="inicio">
        </div>
        <div>
          <label for="fim">Fechamento:</label>
          <input type="time" id="fim">
        </div>
      </div>
      <button class="btn-principal" onclick="mostrarMensagem()">Salvar</button>
    </section>

    <!-- NOVA SEÇÃO - HORÁRIOS DISPONÍVEIS -->
    <section class="card">
      <h2>Horários Disponíveis para Agendamento</h2>
      <form id="form-horarios">
        <div class="form-group">
          <label for="dia">Dia da Semana:</label>
          <select id="dia" required>
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
            <label for="horaInicio">Início:</label>
            <input type="time" id="horaInicio" required>
          </div>
          <div>
            <label for="horaFim">Fim:</label>
            <input type="time" id="horaFim" required>
          </div>
        </div>
        <button type="submit" class="btn-principal">Adicionar Horário</button>
      </form>

      <div class="exemplos">
        <ul id="lista-horarios">
          <li>Segunda-feira: 09:00 às 17:00</li>
          <li>Quinta-feira: 10:00 às 18:00</li>
        </ul>
      </div>
    </section>

  </main>

  <!-- RODAPÉ -->
  <footer class="rodape">
    © 2025 NailSpot. Todos os direitos reservados.
  </footer>

  <!-- ALERTAS -->
  <div id="alerta-sucesso" class="alerta">Horário salvo com sucesso!</div>
  <div id="caixa-confirmacao" class="confirmacao">
    <p>Deseja realmente excluir este funcionário?</p>
    <button class="btn-confirmar" onclick="fecharConfirmacao()">Confirmar</button>
    <button class="btn-cancelar" onclick="fecharConfirmacao()">Cancelar</button>
  </div>

  <!-- JAVASCRIPT -->
  <script>
    // Mensagem ao salvar horário
    function mostrarMensagem() {
      const alerta = document.getElementById("alerta-sucesso");
      alerta.classList.add("mostrar");
      setTimeout(() => alerta.classList.remove("mostrar"), 2500);
    }

    // Confirmação visual ao excluir
    function confirmarExclusao() {
      const caixa = document.getElementById("caixa-confirmacao");
      caixa.classList.add("mostrar");
    }

    function fecharConfirmacao() {
      const caixa = document.getElementById("caixa-confirmacao");
      caixa.classList.remove("mostrar");
    }

    // Simulação de adição de funcionário
    document.getElementById("form-funcionario").addEventListener("submit", function(e) {
      e.preventDefault();
      alert("Funcionário adicionado com sucesso! (Simulação visual)");
      this.reset();
    });

    // Adicionar novo horário de agendamento
    document.getElementById("form-horarios").addEventListener("submit", function(e) {
      e.preventDefault();
      const dia = document.getElementById("dia").value;
      const inicio = document.getElementById("horaInicio").value;
      const fim = document.getElementById("horaFim").value;

      if (dia && inicio && fim) {
        const lista = document.getElementById("lista-horarios");
        const novo = document.createElement("li");
        novo.textContent = `${dia}: ${inicio} às ${fim}`;
        lista.appendChild(novo);
        this.reset();
      }
    });
  </script>

</body>
</html>