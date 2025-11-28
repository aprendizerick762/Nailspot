<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nailspot | Serviços</title>
  <link rel="stylesheet" href="css/cliente-servicos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>

<body>
  <header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="Logo NailSpot">
      <span class="nomeLogo">NailSpot</span>
    </div>
    <nav>
      <ul>
        <li><a href="cliente-servicos.php" class="ativo">Serviços</a></li>
        <li><a href="cliente-agenda.php">Agenda</a></li>
        <li><a href="cliente-perfil.php">Perfil</a></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h1>Nossos Serviços</h1>
    <p class="subtitle">Escolha o serviço desejado para agendar ou entrar em contato</p>

    <div class="card-servico">
      <h3>Beleza Pura</h3>
      <div class="info-box">
        <p class="linha-info">
          <i class="icon fa-solid fa-location-dot"></i>
          Rua das Flores, 123 - Centro
        </p>

        <p class="linha-info">
          <i class="icon fa-solid fa-phone"></i>
          (11) 98765-4321
        </p>

        <p class="linha-info">
          <i class="icon fa-regular fa-clock"></i>
          09:00 - 18:00
        </p>

        <div class="tags">
          <span>Manicure</span>
          <span>Pedicure</span>
        </div>
      </div>
      <span class="preco">R$ 30,00</span>
      <div class="botoes">
        <button class="botao rosa" onclick="window.location.href='agendamento-cliente.html'">Agendar</button>
        <button class="botao branco" onclick="window.location.href='cliente-contato.php'">Contato</button>
      </div>
    </div>

    <div class="card-servico">
      <h3>Beleza Pura</h3>
      <div class="info-box">
        <p class="linha-info">
          <i class="icon fa-solid fa-location-dot"></i>
          Rua das Flores, 123 - Centro
        </p>

        <p class="linha-info">
          <i class="icon fa-solid fa-phone"></i>
          (11) 98765-4321
        </p>

        <p class="linha-info">
          <i class="icon fa-regular fa-clock"></i>
          09:00 - 18:00
        </p>

        <div class="tags">
          <span>Manicure</span>
          <span>Pedicure</span>
        </div>
              </div>

        <span class="preco">R$ 30,00</span>
        <div class="botoes">
          <button class="botao rosa" onclick="window.location.href='novo-agendamento.html'">Agendar</button>
          <button class="botao branco" onclick="window.location.href='contato.html'">Contato</button>
        </div>


    </div>
  </main>
  <footer class="rodape">
    <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
  </footer>
</body>

</html>