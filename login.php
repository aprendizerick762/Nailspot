<?php
session_start();
require "php/dbconnect.php";
require "php/mensagem.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $senha = $_POST['senha'];
    $tipo  = $_POST['tipo_login']; // cliente | empresa | funcionario


    /* ============================================================
       LOGIN COMO CLIENTE  ✔ Agora usando password_verify()
    ============================================================ */
    if ($tipo === "cliente") {

        $sql = "SELECT * FROM clientes WHERE email='$email' LIMIT 1";
        $result = mysqli_query($connect, $sql);
        $cliente = mysqli_fetch_assoc($result);

        if (!$cliente) {
            $_SESSION['mensagem'] = "E-mail de cliente não encontrado!";
            header("Location: login.php");
            exit;
        }

        // Agora cliente também usa senha HASH
        if (!password_verify($senha, $cliente['senha'])) {
            $_SESSION['mensagem'] = "Senha incorreta!";
            header("Location: login.php");
            exit;
        }

        $_SESSION['cliente_id'] = $cliente['id'];
        $_SESSION['mensagem'] = "Login como cliente realizado!";
        header("Location: cliente-servicos.php");
        exit;
    }



    /* ============================================================
       LOGIN COMO EMPRESA  ✔ Já funcionava com hash
    ============================================================ */
    if ($tipo === "empresa") {

        $sql = "SELECT * FROM empresa WHERE email='$email' LIMIT 1";
        $result = mysqli_query($connect, $sql);
        $empresa = mysqli_fetch_assoc($result);

        if (!$empresa) {
            $_SESSION['mensagem'] = "E-mail de empresa não encontrado!";
            header("Location: login.php");
            exit;
        }

        if (!password_verify($senha, $empresa['senha'])) {
            $_SESSION['mensagem'] = "Senha incorreta!";
            header("Location: login.php");
            exit;
        }

        $_SESSION['empresa_id'] = $empresa['id'];
        $_SESSION['mensagem'] = "Login como empresa realizado!";
        header("Location: empresa-dashboard.php");
        exit;
    }



    /* ============================================================
       LOGIN COMO FUNCIONÁRIO  ✔ Agora também com senha hash
    ============================================================ */
    if ($tipo === "funcionario") {

        $sql = "SELECT * FROM funcionarios WHERE email='$email' LIMIT 1";
        $result = mysqli_query($connect, $sql);
        $func = mysqli_fetch_assoc($result);

        if (!$func) {
            $_SESSION['mensagem'] = "Funcionário não encontrado!";
            header("Location: login.php");
            exit;
        }

        // Também usando hash agora
        if (!password_verify($senha, $func['senha'])) {
            $_SESSION['mensagem'] = "Senha incorreta!";
            header("Location: login.php");
            exit;
        }

        $_SESSION['funcionario_id'] = $func['id'];
        $_SESSION['mensagem'] = "Login como funcionário realizado!";
        header("Location: funcionario-home.php");
        exit;
    }



    /* ============================================================
       SE NADA SE ENCAIXA → ERRO
    ============================================================ */
    $_SESSION['mensagem'] = "Erro inesperado no login!";
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
                <div class="login-tipo-box">
                    <p class="titulo-tipo">Entrar como:</p>

                    <label class="radio-opcao">
                        <input type="radio" name="tipo_login" value="cliente" checked>
                        Cliente
                    </label>

                    <label class="radio-opcao">
                        <input type="radio" name="tipo_login" value="empresa">
                        Empresa
                    </label>

                    <label class="radio-opcao">
                        <input type="radio" name="tipo_login" value="funcionario">
                        Funcionário
                    </label>
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