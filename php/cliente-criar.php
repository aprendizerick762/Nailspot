<?php
// Senha sem Criptografia
//Iniciar Sessão
session_start();

//Conexão
require_once 'dbconnect.php';

if(isset($_POST['btn-cadastrar'])):
    $nome = mysqli_escape_string($connect, $_POST['nome']);
    $email = mysqli_escape_string($connect, $_POST['email']);
    $cpf = mysqli_escape_string($connect, $_POST['cpf']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);
    

    $sql = "INSERT INTO clientes(nome, email, cpf, senha) VALUES ('$nome', '$email', '$cpf', '$senha')";
    
    if(mysqli_query($connect, $sql)):
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    else:
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($connect);        
    endif;
    
    header('Location: ../cliente-cadastro.html');
    exit;
endif;

//Senha com criptografia
// session_start();
// require_once __DIR__ . '/dbconnect.php';

// if (!isset($connect) || !$connect) {
//     $_SESSION['mensagem'] = "Erro: conexão com o banco não estabelecida.";
//     header('Location: ../cliente-cadastro.html');
//     exit;
// }

// if (isset($_POST['btn-cadastrar'])):
//     $nome = trim($_POST['nome'] ?? '');
//     $email = trim($_POST['email'] ?? '');
//     $cpf = trim($_POST['cpf'] ?? '');
//     $senha = $_POST['senha'] ?? '';

//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $_SESSION['mensagem'] = "E-mail inválido.";
//         header('Location: ../cliente-cadastro.html');
//         exit;
//     }

//     $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

//     $sql = "INSERT INTO clientes (nome, email, cpf, senha) VALUES (?, ?, ?, ?)";
//     if ($stmt = mysqli_prepare($connect, $sql)) {
//         mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $cpf, $senha_hash);
//         if (mysqli_stmt_execute($stmt)) {
//             $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
//         } else {
//             $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_stmt_error($stmt);
//         }
//         mysqli_stmt_close($stmt);
//     } else {
//         $_SESSION['mensagem'] = "Erro na preparação da query: " . mysqli_error($connect);
//     }

//     header('Location: ../cliente-cadastro.html');
//     exit;
// endif;
//


?> 