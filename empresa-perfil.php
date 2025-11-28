<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// VERIFICAR SE A EMPRESA ESTÁ LOGADA
if (!isset($_SESSION['empresa_id'])) {
    header("Location: login.php");
    exit;
}

$empresa_id = $_SESSION['empresa_id'];

// BUSCAR INFORMAÇÕES DA EMPRESA
$sql = "SELECT * FROM empresa WHERE id = $empresa_id LIMIT 1";
$result = mysqli_query($connect, $sql);
$empresa = mysqli_fetch_assoc($result);

// SE NÃO ACHAR, O USUÁRIO NÃO DEVERIA ESTAR LOGADO
if (!$empresa) {
    $_SESSION['mensagem'] = "Erro: empresa não encontrada!";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Perfil da Empresa | NailSpot</title>
  <link rel="stylesheet" href="css/empresa-perfil.css">
  <link rel="shortcut icon" href="img/LogoNailspotofc.png" >
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
        <li><a href="empresa-dashboard.php">Dashboard</a></li>
        <li><a href="empresa-perfil.php" class="ativo">Perfil</a></li>
      </ul>
    </nav>
  </header>

  <!-- CONTEÚDO -->
  <main class="conteudo">
    <section class="card">
      <h2>Dados da Empresa</h2>
      <form action="empresa-perfil.php" method="POST" id="form-perfil">
        <div class="form-group">
          <label for="razao">Nome / Razão Social</label>
          <input type="text" id="razao" value="NailSpot Beauty Studio" required>
        </div>

        <div class="form-group">
          <label for="cnpj">CNPJ</label>
          <input type="text" id="cnpj" value="12.345.678/0001-99" required>
        </div>

        <div class="form-group">
          <label for="cep">CEP</label>
          <input type="text" id="cep" value="01234-567" required>
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" value="contato@nailspot.com" required>
        </div>

        <div class="form-group">
          <label for="telefone">Telefone</label>
          <input type="text" id="telefone" value="(11) 98765-4321" required>
        </div>

        <div class="form-group">
          <label for="endereco">Endereço</label>
          <input type="text" id="endereco" value="Rua das Rosas, 123 - São Paulo/SP" required>
        </div>

        <button type="submit" class="btn-principal">Salvar Alterações</button>
      </form>
    </section>

    <section class="card">
      <h2>Segurança</h2>
      <button class="btn-principal" id="btn-alterar-senha">Alterar Senha</button>
    </section>
  </main>

  <!-- MODAL ALTERAR SENHA -->
  <div id="modal-senha" class="modal">
    <div class="modal-conteudo">
      <h3>Alterar Senha</h3>
      <form id="form-senha">
        <div class="form-group">
          <label for="nova-senha">Nova Senha:</label>
          <input type="password" id="nova-senha" required>
        </div>
        <div class="form-group">
          <label for="confirmar-senha">Confirmar Senha:</label>
          <input type="password" id="confirmar-senha" required>
        </div>
        <div class="botoes-modal">
          <button type="submit" class="btn-principal">Salvar</button>
          <button type="button" class="btn-cancelar" id="fechar-modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- RODAPÉ -->
  <footer class="rodape">
    <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
  </footer>

  <!-- JAVASCRIPT -->
  <script>
// MOSTRAR MODAL
document.getElementById('btn-alterar-senha').addEventListener('click', () => {
    document.getElementById('modal-senha').classList.add('mostrar');
});

// FECHAR MODAL
document.getElementById('fechar-modal').addEventListener('click', () => {
    document.getElementById('modal-senha').classList.remove('mostrar');
});
</script>
</body>
</html>