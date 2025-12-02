<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

// =======================
// 1. VERIFICA LOGIN
// =======================
if (!isset($_SESSION['cliente_id'])) {
    // Caso não esteja logado, redireciona
    header("Location: login.php");
    exit;
}

$id = $_SESSION['cliente_id'];


// =======================
// 2. ATUALIZAR DADOS
// =======================
if (isset($_POST['atualizar'])) {

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $telefone = $_POST['telefone'];

    $update = "UPDATE clientes 
               SET nome='$nome', cpf='$cpf', email='$email', cep='$cep', telefone='$telefone'
               WHERE id=$id";

    if (mysqli_query($connect, $update)) {
        $_SESSION['mensagem'] = "Dados atualizados com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar dados!";
    }

    header("Location: ../cliente-perfil.php");
    exit;
}


// =======================
// 3. ALTERAR SENHA 
// =======================
if (isset($_POST['alterar_senha'])) {

    $novaSenha = trim($_POST['nova_senha']);

    // Requisitos da senha
    $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@!#$%_\-]).{8,}$/";

    if (!preg_match($regex, $novaSenha)) {
        $_SESSION['mensagem'] = "A senha não atende aos requisitos!";
        header("Location: cliente-perfil.php");
        exit;
    }

    // Criptografar senha
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    $sqlSenha = "UPDATE clientes SET senha='$senhaHash' WHERE id=$id";

    if (mysqli_query($connect, $sqlSenha)) {
        $_SESSION['mensagem'] = "Senha alterada com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao alterar senha!";
    }

    header("Location: cliente-perfil.php");
    exit;
}

// =======================
// 4. CARREGAR DADOS DO USUÁRIO
// =======================
$sql = "SELECT * FROM clientes WHERE id=$id";
$result = mysqli_query($connect, $sql);
$cliente = mysqli_fetch_assoc($result);


// // VERIFICAR SE A EMPRESA ESTÁ LOGADA
// if (!isset($_SESSION['empresa_id'])) {
//     header("Location: login.php");
//     exit;
// }

// $empresa_id = $_SESSION['empresa_id'];

// // BUSCAR INFORMAÇÕES DA EMPRESA
// $sql = "SELECT * FROM empresa WHERE id = $empresa_id LIMIT 1";
// $result = mysqli_query($connect, $sql);
// $empresa = mysqli_fetch_assoc($result);

// // SE NÃO ACHAR, O USUÁRIO NÃO DEVERIA ESTAR LOGADO
// if (!$empresa) {
//     $_SESSION['mensagem'] = "Erro: empresa não encontrada!";
//     header("Location: login.php");
//     exit;
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - NailSpot</title>
    <link rel="stylesheet" href="css/cliente-perfil.css">
    <link rel="shortcut icon" href="img/LogoNailspotofc.png">
</head>

<body>
    <header class="navbar">
        <div class="logo">
            <img src="img/LogoNailspotofc.png" alt="Logo Nailspot">
            <span class="nome-logo">NailSpot</span>
        </div>
        <nav>
            <ul>
                <li><a href="cliente-servicos.php">Serviços</a></li>
                <li><a href="cliente-agenda.php">Agenda</a></li>
                <li><a href="cliente-perfil.php" class="ativo">Perfil</a></li>
                <li><a href="login.php">Sair</a></li>
            </ul>
        </nav>
        <!-- <div class="perfil">
            <span>Mirella</span>
            <img src="perfil.jpg" alt="Perfil">
            <button class="btn-perfil">Perfil Cliente</button>
        </div> -->
    </header>

    <main>
        <section class="perfil-container">
            <h2>Configurações do Perfil</h2>
            <p>Gerencie suas informações pessoais</p>


            <form action="cliente-perfil.php" method="POST">

                <div class="bloco">
                    <h3>Informações Pessoais</h3>

                    <div class="campo">
                        <label>Nome Completo</label>
                        <div class="input-edit">
                            <input type="text" name="nome" value="<?= $cliente['nome'] ?>" readonly>
                            <button type="button" class="editar">✎</button>
                        </div>
                    </div>

                    <div class="campo">
                        <label>CPF</label>
                        <div class="input-edit">
                            <input type="text" name="cpf" value="<?= $cliente['cpf'] ?>" readonly>
                            <button type="button" class="editar">✎</button>
                        </div>
                    </div>

                    <div class="campo">
                        <label>E-mail</label>
                        <div class="input-edit">
                            <input type="email" name="email" value="<?= $cliente['email'] ?>" readonly>
                            <button type="button" class="editar">✎</button>
                        </div>
                    </div>

                    <div class="campo">
                        <label>Telefone</label>
                        <div class="input-edit">
                            <input type="text" name="telefone" value="<?= $cliente['telefone'] ?>" readonly>
                            <button type="button" class="editar">✎</button>
                        </div>
                    </div>

                    <button type="submit" name="atualizar" id="salvar" class="btn-salvar" style="display:none">
                        Salvar Alterações
                    </button>

                </div>
            </form>

            

            <!-- Alterar Senha -->
            <form action="cliente-perfil.php" method="POST">
                <div class="bloco seguranca" class="input-edit">
                    <h3>Segurança</h3>

                    <input type="password" id="novas" name="nova_senha" placeholder="Nova senha">

                    <button type="submit" name="alterar_senha" class="btn-alterar">
                        Alterar Senha
                    </button>

                </div>
            </form>
            <div class="regras-senha">
                <p>Sua senha deve conter:</p>
                <ul>
                    <li>Mínimo 8 caracteres</li>
                    <li>Letra maiúscula</li>
                    <li>Letra minúscula</li>
                    <li>Número</li>
                    <li>Caractere especial (@!#$%)</li>
                </ul>
            </div>
        </section>
    </main>


    <script>
        // Ativar edição
        document.querySelectorAll(".editar").forEach(btn => {
            btn.addEventListener("click", function () {
                const input = this.parentElement.querySelector('input');
                input.removeAttribute("readonly");
                input.focus();

                // Mostra o botão salvar
                document.getElementById("salvar").style.display = "block";

                // Muda a aparência do campo para modo edição
                input.style.background = "#fff";
                input.style.borderColor = "#e26ca5";
            });
        });
    </script>
    <footer class="rodape">
        <p>© 2025 NailSpot - Seu momento de beleza e bem-estar</p>
    </footer>
</body>

</html>