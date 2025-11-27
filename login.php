<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

if (isset($_POST['email']) && isset($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    /* =====================================
       1) TENTAR LOGIN COMO CLIENTE
    ======================================*/

    $sql = "SELECT * FROM clientes WHERE email='$email' LIMIT 1";
    $result = mysqli_query($connect, $sql);
    $cliente = mysqli_fetch_assoc($result);

    if ($cliente) {

        if ($cliente['senha'] === $senha) {
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['mensagem'] = "Login realizado!";
            header("Location: cliente-servicos.php");
            exit;
        } else {
            $_SESSION['mensagem'] = "Senha incorreta!";
            header("Location: login.php");
            exit;
        }
    }

    /* =====================================
       2) SE NÃO FOR CLIENTE → TENTAR EMPRESA
    ======================================*/

    $sql2 = "SELECT * FROM empresa WHERE email='$email' LIMIT 1";
    $result2 = mysqli_query($connect, $sql2);
    $empresa = mysqli_fetch_assoc($result2);

    if ($empresa) {

        if ($empresa['senha'] === $senha) {
            $_SESSION['empresa_id'] = $empresa['id'];
            $_SESSION['mensagem'] = "Login como empresa realizado!";
            header("Location: empresa-dashboard.php");
            exit;
        } else {
            $_SESSION['mensagem'] = "Senha incorreta!";
            header("Location: login.php");
            exit;
        }
    }

    /* =====================================
       3) NÃO ACHOU EMAIL EM NENHUMA TABELA
    ======================================*/

    $_SESSION['mensagem'] = "E-mail não encontrado!";
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nailspot | Login</title>
    <link rel="stylesheet" href="css/login.css">
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
        <section class="card">
            <h1>Bem-Vindo ao NailSpot</h1>
            <p class="subtitulo">O melhor lugar para seu agendamento de manicure e pedicure!</p>

            <form class="formulario" action="login.php" method="POST">
                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="seuemail@email.com" required>
                </div>

                <div class="campo">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="********" required>
                </div>
                <div class="opção">
                    <a href="esqueci-senha.html" class="esqueciSenha">Esqueci minha senha</a>
                </div>
                <button type="submit" class="btn-login">Entrar</button>
            </form>

            <a href="index.html" class="voltar">← Voltar</a>

            <p class="cadastro-texto">
                Ainda não possui uma conta? <a href="categoria.php" class="link-cadastro">Cadastre-se</a>
            </p>
            
        </section>
        
    </main>
    <footer class="rodape">
        <p>Seu momento de autocuidado está a um clique de distância</p>
    </footer>
</body>
</html>