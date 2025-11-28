<?php

// Senha sem Criptografia
//Iniciar Sessão
session_start();

//Conexão
require_once 'php/dbconnect.php';
require_once 'php/mensagem.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    $nome = mysqli_escape_string($connect, $_POST['nome']);
    $email = mysqli_escape_string($connect, $_POST['email']);
    $cpf_cnpj = mysqli_escape_string($connect, $_POST['cpf_cnpj']);
    $cep = mysqli_escape_string($connect, $_POST['cep']);
    $telefone = mysqli_escape_string($connect, $_POST['telefone']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);


    $sql = "INSERT INTO empresa(nome, email, cpf_cnpj, cep, telefone, senha) VALUES ('$nome', '$email', '$cpf_cnpj','$cep','$telefone','$senha')";

    if (mysqli_query($connect, $sql)):
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    else:
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($connect);
    endif;

    header('Location: manicure-cadastro.php');
    exit;
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nailspot | Cadastro Manicure</title>
    <link rel="stylesheet" href="css/manicure-cadastro.css">
    <script src="js/manicure-cadastro.js" defer></script>
    <link rel="shortcut icon" href="img/LogoNailspotofc.png">

</head>

<body>
    <header class="topo">
        <div class="logo">
            <img src="img/LogoNailspotofc.png" alt="Logo NailSpot">
            <span class="nome">NailSpot</span>
        </div>
    </header>
    <main class="container">
        <h1>Cadastro de Manicure</h1>
        <p>Cadastre seu salão e comece a receber agendamentos de clientes</p>

        <form action="manicure-cadastro.php" method="POST" class="formulario">
            <label for="name">Nome / Razão Social</label>
            <input type="text" id="nome" name="nome" placeholder="Ex:. Maria Silva Santos" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Ex:. meuemail@gmail.com" required>

            <label for="cpf_cnpj">CPF / CNPJ</label>
            <input type="text" id="cpf_cnpj" name="cpf_cnpj" placeholder="00.000.000/0000-00" required>

            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep" placeholder="00000-000" pattern="\d{5}-?\d{3}" required>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="(00)00000-000"
                pattern="\(\d{2}\)\s?\d{4,5}-\d{4}" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="********" required>

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

            <label for="confirm_senha">Confirmar Senha</label>
            <input type="password" id="confirm_senha" name="confirm_senha" placeholder="********" required>



            <div class="botoes">
                <a href="categoria.php" class="btn branco">Voltar</a>
                <button type="submit" name="btn-cadastrar" class="btn rosa">Cadastrar</button>
            </div>
        </form>
    </main>

    <footer class="rodape">
        <p>Estamos felizes em ter você conosco!</p>
    </footer>


</body>

</html>
<!-- <script>
/* Correção do selector e validações */
const form = document.querySelector(".formulario"); // <-- correção aqui (classe)
const senha = document.getElementById("senha");
const confirmar = document.getElementById("confirm_senha");

// Verifica se os elementos foram encontrados
if (!form) {
    console.error("Form (.formulario) não encontrado!");
}
if (!senha || !confirmar) {
    console.error("Campos de senha não encontrados!");
}

if (form) {
    form.addEventListener("submit", function(evento){
        // evita erro caso elementos não existam
        if (!senha || !confirmar) return;

        evento.preventDefault();

        const valor = senha.value.trim();
        const confirmar_valor = confirmar.value.trim();
        // permitir também underscore e hífen, como você já tinha, mas sem espaços
        const senhaForte = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@!#$%_\-]).{8,}$/;

        // Validação da força da senha
        if(!senhaForte.test(valor)){
            alert("A senha não atende aos requisitos:\n- Mínimo 8 caracteres\n- Letra maiúscula\n- Letra minúscula\n- Número\n- Caractere especial (@!#$%_-)");
            senha.focus();
            return;
        }

        // Validação se as senhas coincidem
        if(valor !== confirmar_valor){
            alert("As senhas não coincidem!");
            confirmar.focus();
            return;
        }

        // Se todas as validações passarem, envia o formulário
        form.submit();
    });
}
</script> -->