<?php

// Senha sem Criptografia
//Iniciar Sessão
session_start();

//Conexão
require_once 'dbconnect.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'):
    $nome = mysqli_escape_string($connect, $_POST['nome']);
    $email = mysqli_escape_string($connect, $_POST['email']);
    $cpf_cnpj = mysqli_escape_string($connect, $_POST['cpf_cnpj']);
    $cep = mysqli_escape_string($connect, $_POST['cep']);
    $telefone = mysqli_escape_string($connect, $_POST['telefone']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);
    
 
    $sql = "INSERT INTO empresa(nome, email, cpf_cnpj, cep, telefone, senha) VALUES ('$nome', '$email', '$cpf_cnpj','$cep','$telefone','$senha')";
    
    if(mysqli_query($connect, $sql)):
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    else:
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($connect);        
    endif;
    
    header('Location: ../manicure-cadastro.html');
    exit;
endif;

// session_start();

// // usar caminho seguro para o dbconnect (resolve relativo ao arquivo atual)
// require_once __DIR__ . '/dbconnect.php';

// // Verifica se a conexão $connect está definida e válida
// if (!isset($connect) || !$connect) {
//     $_SESSION['mensagem'] = "Erro: conexão com o banco não estabelecida.";
//     header('Location: ../manicure-cadastro.html');
//     exit;
// }

// if (isset($_POST['btn-cadastrar'])):
//     $nome = trim($_POST['nome'] ?? '');
//     $email = trim($_POST['email'] ?? '');
//     $cpf_cnpj = trim($_POST['cpf_cnpj'] ?? '');
//     $cep = trim($_POST['cep'] ?? '');
//     $telefone = trim($_POST['telefone'] ?? '');
//     $senha = $_POST['senha'] ?? '';

//     // validar campos básicos (ex.: email)
//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $_SESSION['mensagem'] = "E-mail inválido.";
//         header('Location: ../manicure-cadastro.html');
//         exit;
//     }

//     // hash da senha
//     $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

//     // prepared statement para evitar SQL injection
//     $sql = "INSERT INTO empresa (nome, email, cpf_cnpj, cep, telefone, senha) VALUES (?, ?, ?, ?, ?, ?)";
//     if ($stmt = mysqli_prepare($connect, $sql)) {
//         mysqli_stmt_bind_param($stmt, "ssssss", $nome, $email, $cpf_cnpj, $cep, $telefone, $senha_hash);
//         if (mysqli_stmt_execute($stmt)) {
//             $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
//         } else {
//             $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_stmt_error($stmt);
//         }
//         mysqli_stmt_close($stmt);
//     } else {
//         $_SESSION['mensagem'] = "Erro na preparação da query: " . mysqli_error($connect);
//     }

//     header('Location: ../manicure-cadastro.html');
//     exit;
// endif;
?>