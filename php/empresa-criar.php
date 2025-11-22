<?php
//Iniciar Sessão
session_start();

//Conexão
require_once 'dbconnect.php';

if(isset($_POST['btn-cadastrar'])):
    $nome = mysqli_escape_string($connect, $_POST['nome']);
    $email = mysqli_escape_string($connect, $_POST['email']);
    $cpf_cnpj = mysqli_escape_string($connect, $_POST['cpf_cnpj']);
    $cep = mysqli_escape_string($connect, $_POST['cep']);
    $telefone = mysqli_escape_string($connect, $_POST['telefone']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);
    

    $sql = "INSERT INTO empresa(nome, email, cpf_cnpj, cep, telefone, senha) VALUES ('$nome', '$email', '$cpf_cnpj', '$cep', '$telefone', '$senha')";
    
    if(mysqli_query($connect, $sql)):
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    else:
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($connect);        
    endif;
    
    header('Location: ../manicure-cadastro.html');
    exit;
endif;
?>