<?php
session_start();
require "php/dbconnect.php";

// Impedir acesso sem login
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit;
}

$funcionario_id = $_SESSION['funcionario_id'];

// ======================================================
// 1) BUSCAR DADOS DO FUNCIONÁRIO
// ======================================================
$sql = "SELECT * FROM funcionarios WHERE id = $funcionario_id LIMIT 1";
$result = mysqli_query($connect, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Erro: Funcionário não encontrado.");
}

$func = mysqli_fetch_assoc($result);

// ======================================================
// 2) ATUALIZAR DADOS
// ======================================================
if (isset($_POST['salvar_perfil'])) {
    $nome = mysqli_real_escape_string($connect, $_POST['nome']);
    $cpf = mysqli_real_escape_string($connect, $_POST['cpf']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $telefone = mysqli_real_escape_string($connect, $_POST['telefone']);

    $sqlUpdate = "UPDATE funcionarios 
                  SET nome='$nome', cpf='$cpf', email='$email', telefone='$telefone'
                  WHERE id = $funcionario_id";

    mysqli_query($connect, $sqlUpdate);

    header("Location: funcionario-perfil.php?ok=1");
    exit;
}

// ======================================================
// 3) ATUALIZAR SENHA
// ======================================================
if (isset($_POST['salvar_senha'])) {
    $senha = mysqli_real_escape_string($connect, $_POST['senha']);

    // Para segurança, HASH!
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    mysqli_query($connect, "UPDATE funcionarios SET senha='$senhaHash' WHERE id=$funcionario_id");

    header("Location: funcionario-perfil.php?senha=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - Funcionário | NailSpot</title>
  <link rel="stylesheet" href="css/perfil-funcionario.css">
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
        <li><a href="funcionario-home.php">Home</a></li>
        <li><a href="funcionario-perfil.php" class="ativo">Perfil</a></li>
        <li><a href="login.php">Sair</a></li>
      </ul>
    </nav>
</header>

<main class="conteudo">

<?php if(isset($_GET['ok'])): ?>
  <div class="alert-sucesso">Dados atualizados com sucesso!</div>
<?php endif; ?>

<?php if(isset($_GET['senha'])): ?>
  <div class="alert-sucesso">Senha alterada com sucesso!</div>
<?php endif; ?>

<section class="card">
  <h2>Dados Pessoais</h2>
  <form id="form-perfil" method="POST">

    <div class="form-group">
      <label for="nome">Nome Completo</label>
      <input type="text" id="nome" name="nome" value="<?= $func['nome'] ?>" required>
    </div>

    <div class="form-group">
      <label for="cpf">CPF</label>
      <input type="text" id="cpf" name="cpf" value="<?= $func['cpf'] ?>" required>
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" value="<?= $func['email'] ?>" required>
    </div>

    <div class="form-group">
      <label for="telefone">Telefone</label>
      <input type="text" id="telefone" name="telefone" value="<?= $func['telefone'] ?>" required>
    </div>

    <button type="submit" name="salvar_perfil" class="btn-principal">
      Salvar Alterações
    </button>

  </form>
</section>

<section class="card">
  <h2>Segurança</h2>
  <button class="btn-principal" id="btn-alterar-senha">Alterar Senha</button>
</section>

</main>

<!-- Modal de alterar senha -->
<div id="modal-senha" class="modal">
  <div class="modal-conteudo">
    <h3>Alterar Senha</h3>

    <form id="form-senha" method="POST">

      <div class="form-group">
        <label for="nova-senha">Nova Senha:</label>
        <input type="password" id="nova-senha" required>
      </div>

      <div class="form-group">
        <label for="confirmar-senha">Confirmar Senha:</label>
        <input type="password" id="confirmar-senha" required>
      </div>

      <input type="hidden" name="senha" id="senha_real">
      <button type="submit" name="salvar_senha" class="btn-principal">Salvar</button>

      <button type="button" class="btn-cancelar" id="fechar-modal">
        Cancelar
      </button>
    </form>

  </div>
</div>

<footer class="rodape">
  <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
</footer>

<script>
// Abrir modal
document.getElementById('btn-alterar-senha').addEventListener('click', () => {
  document.getElementById('modal-senha').classList.add('mostrar');
});

// Fechar modal
document.getElementById('fechar-modal').addEventListener('click', () => {
  document.getElementById('modal-senha').classList.remove('mostrar');
});

// Validar e enviar alteração de senha
document.getElementById('form-senha').addEventListener('submit', e => {
  e.preventDefault();

  const nova = document.getElementById('nova-senha').value;
  const confirmar = document.getElementById('confirmar-senha').value;

  if(nova !== confirmar){
    alert('As senhas não coincidem!');
    return;
  }

  document.getElementById('senha_real').value = nova;
  e.target.submit();
});
</script>

</body>
</html>