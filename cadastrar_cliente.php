<?php

function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

if(count($_POST)> 0){

    include('conexao.php');

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    if(empty($nome)){
        $erro = "ERRO: O campo Nome é obrigatório!";
    }
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "ERRO: O campo E-mail é obrigatório!";
    }

    if(!empty($data_nascimento)){
        $fragmentos = explode('/', $data_nascimento);
        
        if (count($fragmentos) == 3) {
        $data_nascimento = implode('-', array_reverse($fragmentos)); 
        } else {
            $erro = "O campo Data de Nascimento deve seguir o padrão DD/MM/YYYY !";
        }
    }

    if(!empty($telefone)){
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11){
            $erro = "O campo telefone deve conter 11 dígitos!";
        }
    }

    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    } else {
        $sql_code = "INSERT INTO clientes (nome, email, telefone, data_nascimento, data) 
        VALUES ('$nome', '$email', '$telefone', '$data_nascimento', NOW())";
        $sucesso = $mysqli->query($sql_code) or die($mysqli->error);
        if($sucesso){
            echo "<p><b>Cliente cadastrado com sucesso!</b></p>";
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
</head>
<body>
    <a href="clientes.php">Voltar para a lista</a>
    <form method="POST" action="">
        <p>
            <label for="">Nome:</label>
            <input value="<?php ?>" name="nome" type="text"><br>
        </p>
        <p>
            <label for="">E-mail:</label>
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" name="email" type="text"><br>
        </p>
        <p>
            <label for="">Telefone:</label>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone'];?>" placeholder="(11) 91111-1111" name="telefone" type="text"><br>
        </p>
        <p>
            <label for="">Data de Nascimento:</label>
            <input value="<?php if(isset($_POST['data_nascimento'])) echo $_POST['data_nascimento'];?>" name="data_nascimento" type="text"><br>
        </p>
        <p>
            <button type="submit">Concluir Cadastro</button>
        </p>
    </form>
    
</body>
</html>