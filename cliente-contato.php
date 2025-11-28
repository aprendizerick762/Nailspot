<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato - NailSpot</title>
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
        <li><a href="http://127.0.0.1:5500/cliente-servicos.php" class="ativo">Serviços</a></li>
        <li><a href="http://127.0.0.1:5500/cliente-agenda.php">Agenda</a></li>
        <li><a href="http://127.0.0.1:5500/cliente-perfil.php">Perfil</a></li>
      </ul>
    </nav>
    
    <!-- um possivel dseign para perfil
     <div class="perfil">
      <span>Mirella</span>
      <span class="perfil-cliente">Perfil Cliente</span>
      <img src="https://cdn-icons-png.flaticon.com/512/2922/2922506.png" alt="Perfil">
    </div> -->
  </header>

  <main class="container">
    <h1>Contato</h1>
    <p class="subtitulo">Entre em contato com o estabelecimento</p>

    <section class="conteudo">
      <div class="card-contato">
        <h2>Beleza Pura</h2>
        <div class="mapa"></div>

        <div class="info">
          <div class="info-item">
            <span class="icon">📍</span>
            <div>
              <strong>Endereço</strong>
              <p>Rua das Flores, 123 - Centro<br>São Paulo, SP - CEP 01234-567</p>
            </div>
          </div>

          <div class="info-item">
            <span class="icon">📞</span>
            <div>
              <strong>Telefone</strong>
              <p>(11) 98765-4321<br><small>WhatsApp disponível</small></p>
            </div>
          </div>

          <div class="info-item">
            <span class="icon">⏰</span>
            <div>
              <strong>Horário de Funcionamento</strong>
              <p>Segunda a Sexta: 09:00 - 18:00<br>Sábado: 09:00 - 14:00</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card-mensagem">
        <h2>Enviar Mensagem</h2>

        <label>Seu Nome</label>
        <input type="text" placeholder="Maria Silva">

        <label>Seu E-mail</label>
        <input type="email" placeholder="meuemail@gmail.com">

        <label>Mensagem</label>
        <textarea placeholder="Digite sua mensagem aqui..."></textarea>

        <div class="botoes">
          <button class="botao branco">Voltar</button>
          <button class="botao rosa">Enviar Mensagem</button>
        </div>

        <div class="dica">
          <strong>Dica:</strong> Para atendimento mais rápido, entre em contato via WhatsApp ou telefone durante o horário de funcionamento.
        </div>
      </div>
    </section>
  </main>
      <footer class="rodape">
        <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
    </footer>
</body>
</html>
