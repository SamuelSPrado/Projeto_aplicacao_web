<?php

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['usuario']) || !$_SESSION['admin'])
{
    header("Location: index.php");
    die();
}

function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

if(count($_POST)> 0)
{
    include('lib/conexao.php');
    include("lib/upload.php");
    include('lib/mail.php');

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];
    $senha_primaria = $_POST['senha'];
    $admin = $_POST['admin'];

    if(strlen($senha_primaria) < 6 && strlen($senha_primaria) > 16)
    {
        $erro = "<p class='msg_fail'>A senha de conter entre 6 e 16 caracteres</p>";
    }

    //Antes de criptografar

    if(empty($nome))
    {
        $erro = "<p class='msg_fail'>ERRO: O campo Nome é obrigatório!</p>";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $erro = "<p class='msg_fail'>ERRO: O campo E-mail é obrigatório!</p>";
    }

    if(!empty($data_nascimento))
    {
        $fragmentos = explode('/', $data_nascimento);
        
        if (count($fragmentos) == 3)
        {
        $data_nascimento = implode('-', array_reverse($fragmentos)); 
        }
        else
        {
            $erro = "<p class='msg_fail'>O campo Data de Nascimento deve seguir o padrão DD/MM/YYYY !</p>";
        }
    }

    if(!empty($telefone))
    {
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11)
        {
            $erro = "<p class='msg_fail'>O campo telefone deve conter 11 dígitos!</p>";
        }
    }

    $path = "";
    if(isset($_FILES['foto']))
    {
        $arq = $_FILES['foto'];
        $path = enviarArquivo(
            $arq['error'], 
            $arq['size'], 
            $arq['name'], 
            $arq['tmp_name']);

        if($path == false)
            $erro = "<p class='msg_fail'>Falha ao enviar arquivo</p>";
    }

    if($erro)
    {
        echo "<p><b>ERRO: $erro</b></p>";
    }
    else
    {
        $senha = password_hash($senha_primaria, PASSWORD_DEFAULT); //Recebe a senha criptografada.
        
            $sql_code = "INSERT INTO clientes (
                nome, 
                email, 
                senha, 
                telefone, 
                data_nascimento, 
                data, 
                foto, 
                admin
            ) VALUES (
                '$nome', 
                '$email', 
                '$senha', 
                '$telefone', 
                '$data_nascimento',
                NOW(), 
                '$path', 
                '$admin')";

        $sucesso = $mysqli->query($sql_code) or die($mysqli->error);
        if($sucesso)
        {
            echo "<p class='msg_sucess'><b>Cliente cadastrado com sucesso!</b></p>";
            unset($_POST);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Clientes</title>
    <link rel="stylesheet" href="estilos/cadastro.css">
</head>
<body>
    <header class="cabecalho">
        <div class="caixa"> 
            <nav>
                <ul>
                    <li><a href="clientes.php">Tabela de clientes</a></li>
                    <li><a href="index.php">Sair</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <form enctype="multipart/form-data" method="POST" action="">
            <p class="formulario">
                <label for="">Nome:</label>
                <input value="<?php if(isset($_POST['nome'])) echo $_POST['nome'];?>" name="nome" type="text">   
            </p>
            <p class="formulario">
                <label for="">E-mail:</label>
                <input value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" name="email" type="text">
            </p>
            <p class="formulario">
                <label for="">Telefone:</label>
                <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone'];?>" placeholder="(11) 91111-1111" name="telefone" type="text">
            </p>
            <p class="formulario">
                <label for="">Data de Nascimento:</label>
                <input value="<?php if(isset($_POST['data_nascimento'])) echo $_POST['data_nascimento'];?>" name="data_nascimento" type="text">
            </p>
            <p class="formulario">
                <label for="">Senha:</label>
                <input value="<?php if(isset($_POST['senha'])) echo $_POST['senha'];?>" name="senha" type="password">
            </p>
            <p>
            <label for="">Tipo de conta:</label>    
            <input name="admin" value="1" type="radio">ADMIN
            <input name="admin" value="0" checked type="radio">CLIENTE 
            </p>
            <div class="arquivo">
                <label class="foto" for="arquivo">UPLOAD</label>
                <input name="foto" type="file" id="arquivo">  
            </div>
            <div class="local-botao">
                <button type="submit" class="botao">SALVAR</button>
            </div>
        </form>
    </main>
    <footer>
        <p></p>
    </footer>
</body>
</html>