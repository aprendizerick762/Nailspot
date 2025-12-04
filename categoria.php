<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nailspot | Selecione sua categoria</title>
  <link rel="stylesheet" href="css/categoria.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>

<body>
  <header class="navbar">
    <div class="logo">
      <img src="img/LogoNailspotofc.png" alt="Logo NailSpot">
      <span class="nome-logo">NailSpot</span>
    </div>
  </header>

  <main class="container">
    <h1>Selecione sua categoria</h1>
    <p>Escolha o tipo de usuário para continuar seu cadastro</p>

    <form class="form-categoria" onsubmit="return redirecionar(event)">
      <label>
        <input type="radio" name="tipo" value="pessoa">
        <span>Pessoa Física</span>
      </label>
      <label>
        <input type="radio" name="tipo" value="empresa" checked>
        <span>Empresa</span>
      </label>
      <div class="botoes">
        <button type="submit" class="botao rosa">OK</button>
        <a href="index.php" class="botao branco">Voltar</a>
      </div>
    </form>
  </main>

  <footer class="rodape">
    <p>Comece sua jornada de beleza conosco</p>
  </footer>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('.form-categoria');
      if (!form) return;

      form.addEventListener('submit', function (ev) {
        ev.preventDefault();

        const selecionado = form.querySelector('input[name="tipo"]:checked');
        if (!selecionado) {
          alert('Selecione uma categoria para continuar!');
          return;
        }

        if (selecionado.value === 'pessoa') {
          window.location.href = 'cliente-cadastro.php';
        } else {
          window.location.href = 'manicure-cadastro.php';
        }
      });
    });
  </script>
</body>

</html>