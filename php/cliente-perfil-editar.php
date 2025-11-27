<?php
session_start();
require "dbconnect.php";
require "mensagem.php";

// =======================
// 1. VERIFICA LOGIN
// =======================
if(!isset($_SESSION['cliente_id'])){
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

    if(mysqli_query($connect, $update)){
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

    $novaSenha = $_POST['nova_senha'];

    $sqlSenha = "UPDATE clientes SET senha='$novaSenha' WHERE id=$id";

    if(mysqli_query($connect, $sqlSenha)){
        $_SESSION['mensagem'] = "Senha alterada!";
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

?>