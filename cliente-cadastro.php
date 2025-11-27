<?php
// Senha sem Criptografia
//Iniciar Sessão
session_start();

//Conexão
require_once 'php/dbconnect.php';
require_once 'php/mensagem.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'):
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
    
    header('Location: cliente-cadastro.php');
    exit;
endif;
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nailspot | Cadastro Cliente</title>
    <link rel="stylesheet" href="css/cliente-cadastro.css">
    <link rel="shortcut icon" href="img/LogoNailspotofc.png">
    <script src="js/cliente-cadastro.js" defer></script>

</head>

<body>
    <?php include "php/mensagem.php"; ?>
     <header class="navbar">
        <div class="logo">
            <img src="img/LogoNailspotofc.png" alt="Logo NailSpot">
            <span class="nome-logo">NailSpot</span>
        </div>
    </header>

    <main class="container">
        <h1>Cadastro de Cliente</h1>
        <p>Preencha seus dados para criar sua conta e começar a agendar seus serviços</p>

        <form action="cliente-cadastro.php" method="POST" class="formulario" >
            <label>Nome Completo</label>
            <input type="text" name="nome" id="nome" placeholder="EX:. Maria Silva Santos" required>

            <label>E-mail</label>
            <input type="email" name="email" id="email" placeholder="Ex:. meuemail@gmail.com" required>

            <label>CPF</label>
            <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" required>

            <label>Senha</label>
            <input type="password" name="senha" id="senha" placeholder="********" required>

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

            <label>Confirmar Senha</label>
            <input type="password" name="confirm_senha" id="confirm_senha" placeholder="********" required>

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
console.log("SCRIPT DO HTML RODANDO");
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