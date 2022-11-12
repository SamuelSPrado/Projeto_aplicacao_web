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
    <!--<link rel="stylesheet" href="estilos/cliente.css">--->
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="css/button.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/records.css">
    <!--Javascript-->
    <script src="./js/main.js" defer></script>

    <title>Cadastro de clientes</title>
</head>

<body>
    <h1 class="header-title">Lista de Clientes</h1>
        <?php if($_SESSION['admin']) { ?>

            <button type="button" class="button blue mobile" id="cadastrarCliente"><a href="cadastrar_cliente.php">Cadastrar Clientes</a></button>

        <?php } ?>
    <table class="records" border="1" cellpadding="10"> 
        <thead class="thead">
            <th>ID do cliente</th>
            <th>ADMIN</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
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
                        <button type="button" class="button green"><a href="editar_cliente.php?id=<?php echo $cliente['id']?>">Editar</a></button>
                        <button type="button" class="button red"><a href="deletar_cliente.php?id=<?php echo $cliente['id']?>">Deletar</a></button>
                        </td>
                    <?php } ?>
                    </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>

        <!--Inserção de Dados do Cliente-->
        <div class="modal" id="modal">
            <div class="modal-content">
                <header class="modal-header">
                    <h2>Novo Cliente</h2>
                    <span class="modal-close" id="modalClose">&#10006;</span>
                </header>
                <form class="modal-form">
                    <input type="image" src="./img/avatar.svg" class="modal-field" placeholder="Imagem">
                    <input type="number" class="modal-field" placeholder="Id">
                    <input type="email" class="modal-field" placeholder="Admin">
                    <input type="text" class="modal-field" placeholder="Nome">
                    <input type="tel" class="modal-field" placeholder="Telefone">
                    <input type="date" class="modal-field" placeholder="Nascimento">
                    <input type="date" class="modal-field" placeholder="Data Cadastro">
                </form>
                <footer class="modal-footer">
                    <button class="button green">Salvar</button>
                    <button class="button blue">Cancelar</button>
                </footer>
            </div>
        </div>
        <!--Inserção de Dados do Cliente-->

        <button type="button" class="button red"><a href="logout.php">Deslogar</a></button>

    <footer>
        Copyright &copy; Janielle | Samuel | Viviane - ano 2022
    </footer>
</body>
</html>