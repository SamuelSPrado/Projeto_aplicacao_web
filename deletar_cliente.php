<?php

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['usuario']) || !$_SESSION['admin'])
{
    header("Location: index.php");
    die();
}

if(isset($_POST['confirmar']))
{

    include("lib/conexao.php");
    $id = intval($_GET['id']);

    $sql_cliente = "SELECT foto FROM clientes WHERE id = '$id'";
    $query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
    $cliente = $query_cliente->fetch_assoc();

    $sql_code = "DELETE FROM clientes WHERE id = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if($sql_query) {

        if(!empty($cliente['foto']))
            unlink($cliente['foto']);

        ?>    
        <h1>Cliente deletado com sucesso!</h1>
        <p><a href="clientes.php">Clique aqui</a> para voltar para a lista de clientes.</p>
        <?php
        die(); 
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar conta</title>
    <link rel="stylesheet" href="estilos/deletar.css">
</head>

<body>

    <header>
        <h1>Ficamos tristes em te ver partindo!</h1>
        <h2>Tem certeza que deseja deletar/apagar essa conta?</h2>
    </header>

    <main>
    <form action="" method="post">
        <a href="clientes.php">Não</a>
        <button name="confirmar" value="1" type="submit">Sim</button>
    </form>

    <figure>
        <img src="imagens/411faf6190b0abaa48ef69b9c9d4993f.gif" alt="choro">
    </figure>
        
    </main>
</body>

</html>