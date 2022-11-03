<?php
    include('lib/conexao.php');

    if(!isset($_SESSION))
    session_start();

    if(!isset($_SESSION['usuario']))
    {
        header("Location: index.php");
        die();
    }

    $sql_clientes = "SELECT * FROM clientes";
    $query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
    $num_clientes = $query_clientes->num_rows;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Lista de Clientes /</h1>
        <?php if($_SESSION['admin']) { ?>
            <a href="cadastrar_cliente.php">Cadastrar Clientes</a> 
        <?php } ?>
    <table border="1" cellpadding="10"> 
        <thead>
            <th>ID do cliente</th>
            <th>ADMIN</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Nascimento</th>
            <th>Data do cadastro</th>
        <?php if($_SESSION['admin']) { ?>
            <th>Ações</th>
        <?php } ?>
        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                    <tr>
                        <td colspan="<?php if($_SESSION['admin']) echo 9; else echo 8; ?>">Nenhum cliente cadastrado</td>
                    </tr>
            <?php } 
                else {
                    while($cliente = $query_clientes->fetch_assoc()) {

                        $telefone = "Não informado";
                        if(!empty($cliente['telefone'])){
                            $telefone = formatar_telefone($cliente['telefone']);
                        }
                        $dataNascimento = "Não informado";
                        if(!empty($cliente['data_nascimento'])){
                            $dataNascimento = formatar_data($cliente['data_nascimento']);

                        }
                        $dataCadastro = date("d/m/Y H:i",strtotime($cliente['data'])); 
            ?>
                    <tr>
                        <td><?php echo $cliente['id'];?></td>
                        <td><?php if ($cliente['admin']) echo "SIM"; else echo "NÃO";?></td>
                        <td><img height="40" src="<?php echo $cliente['foto'];?>" alt=""></td>
                        <td><?php echo $cliente['nome'];?></td>
                        <td><?php echo $cliente['email'];?></td>
                        <td><?php echo $telefone;?></td>
                        <td><?php echo $dataNascimento;?></td>
                        <td><?php echo $dataCadastro;?></td>
                    <?php if($_SESSION['admin']) { ?>
                        <td>
                            <a href="editar_cliente.php?id=<?php echo $cliente['id']?>">Editar</a>
                            <a href="deletar_cliente.php?id=<?php echo $cliente['id']?>">Deletar</a>
                        </td>
                    <?php } ?>
                    </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
    <p><a href="logout.php">Deslogar</a></p>
</body>
</html>