<?php
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
?>