<?php

include('conexao.php');
$id = intval($_GET['id']);
function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

if(count($_POST)> 0){

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
        $sql_code = "UPDATE clientes SET 
        nome = '$nome', 
        email = '$email', 
        telefone = '$telefone', 
        data_nascimento = '$data_nascimento'
        WHERE id = '$id'";

        $sucesso = $mysqli->query($sql_code) or die($mysqli->error);
        if($sucesso){
            echo "<p><b>Informações salvas com sucesso!</b></p>";
            unset($_POST);
        }
    }
}


$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

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
            <input value="<?php echo $cliente['nome'];?>" name="nome" type="text"><br>
        </p>
        <p>
            <label for="">E-mail:</label>
            <input value="<?php echo $cliente['email'];?>" name="email" type="text"><br>
        </p>
        <p>
            <label for="">Telefone:</label>
            <input value="<?php if(!empty($cliente['telefone']))echo formatar_telefone($cliente['telefone']);?>" placeholder="(11) 91111-1111" name="telefone" type="text"><br>
        </p>
        <p>
            <label for="">Data de Nascimento:</label>
            <input value="<?php if(!empty($cliente['data_nascimento']))echo formatar_data($cliente['data_nascimento']);?>" name="data_nascimento" type="text"><br>
        </p>
        <p>
            <button type="submit">Salvar Alterações</button>
        </p>
    </form>
    
</body>
</html>