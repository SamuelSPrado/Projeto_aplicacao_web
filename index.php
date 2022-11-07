<?php

if(isset($_POST['email']) && isset($_POST['senha']))
{
    include('lib/conexao.php');

    $email = $mysqli->escape_string($_POST['email']);
    $senha = $_POST['senha'];

    $sql_code = "SELECT * FROM clientes WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if($sql_query->num_rows == 0)
    {
        echo "<p class='erro'>E-mail inválido!</p>";
    } 
    else 
    {
        $usuario = $sql_query->fetch_assoc();
        if(!password_verify($senha, $usuario['senha']))
        {
            echo "<p class='erro'>Senha incorreta!</p>";
        }
        else
        {
            if(!isset($_SESSION))
                session_start();

            $_SESSION['usuario'] = $usuario['id'];
            $_SESSION['admin'] = $usuario['admin'];
            header("Location: clientes.php");
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
    <title>Entrar</title>
    <link rel="stylesheet" href="estilos/index.css">
</head>
<body>
    <header>
        <h1>Sistema gerenciador de clientes</h1>
    </header>
    <main>
        <h1>Login</h1>
        <form action="" method="POST">
                <div class="campo">
                    <label for=""></label>
                    <input type="text" name="email" placeholder="E-mail">
                </div>
                <div class="campo">
                    <label for=""></label>
                    <input type="password" name="senha" placeholder="Senha">
                </div>
                <button class="botao" type="submit">Entrar</button>
        </form>
    </main>
</body>
</html>