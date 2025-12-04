<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Define o padrão de codificação dos caracteres da página -->
  <meta charset="UTF-8">

  <!-- Torna o layout responsivo para celulares e tablets -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Título que aparece na aba do navegador -->
  <title>Nailspot | Selecione sua categoria</title>

  <!-- Importa o arquivo CSS da página -->
  <link rel="stylesheet" href="css/categoria.css">

  <!-- Ícone exibido na aba do navegador -->
  <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>

<body>
  <!-- BARRA SUPERIOR (NAVBAR) -->
  <header class="navbar">
    <div class="logo">
      <!-- Logotipo da marca -->
      <img src="img/LogoNailspotofc.png" alt="Logo NailSpot">
      <span class="nome-logo">NailSpot</span>
    </div>
  </header>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="container">

    <!-- Título da página -->
    <h1>Selecione sua categoria</h1>

    <!-- Subtítulo explicativo -->
    <p>Escolha o tipo de usuário para continuar seu cadastro</p>

    <!-- Formulário para escolher o tipo de cadastro -->
    <!-- A função redirecionar() impede o envio padrão e redireciona manualmente -->
    <form class="form-categoria" onsubmit="return redirecionar(event)">

      <!-- Primeira opção: Pessoa Física -->
      <label>
        <input type="radio" name="tipo" value="pessoa">
        <span>Pessoa Física</span>
      </label>

      <!-- Segunda opção: Empresa -->
      <!-- Atributo "checked" deixa pré-selecionado -->
      <label>
        <input type="radio" name="tipo" value="empresa" checked>
        <span>Empresa</span>
      </label>

      <!-- Botões -->
      <div class="botoes">
        <button type="submit" class="botao rosa">OK</button>
        <a href="index.php" class="botao branco">Voltar</a>
      </div>
    </form>
  </main>

  <!-- RODAPÉ -->
  <footer class="rodape">
    <p>Comece sua jornada de beleza conosco</p>
  </footer>

  <!-- JAVASCRIPT RESPONSÁVEL PELA LÓGICA DA PÁGINA -->
  <script>
    /*
      O evento DOMContentLoaded garante que o JavaScript
      só execute quando todo o HTML estiver carregado.
    */
    document.addEventListener('DOMContentLoaded', function () {

      // Seleciona o formulário
      const form = document.querySelector('.form-categoria');
      if (!form) return; // Se não encontrar, interrompe

      /*
        Adiciona um evento de submit ao formulário.
        Esse evento é disparado quando o usuário clica no botão "OK".
      */
      form.addEventListener('submit', function (ev) {

        /*
          Cancela o envio padrão do formulário.
          Assim evitamos um reload da página.
        */
        ev.preventDefault();

        /*
          Recupera qual opção de categoria está selecionada.
          querySelector busca o input do tipo radio selecionado (checked).
        */
        const selecionado = form.querySelector('input[name="tipo"]:checked');

        // Se o usuário não selecionar nada, mostra um alerta
        if (!selecionado) {
          alert('Selecione uma categoria para continuar!');
          return;
        }

        /*
          Dependendo da opção escolhida, redirecionamos o usuário
          para a página correta usando window.location.href
        */
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