<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "crud_cliente";

$mysqli = new mysqli(
    $host, 
    $user, 
    $password, 
    $database
);

if($mysqli->connect_errno)
{
    die("Falha na conexão!");
}

function formatar_data($data)
{
    return implode(
        '/', 
        array_reverse(
            explode(
                '-', 
                $data)
            )
        );
}

function formatar_telefone($telefone)
{       //string, onde começa, tamanho
        $ddd = substr ( $telefone, 0, 2);
        $parte1 = substr ( $telefone, 2, 5);
        $parte2 = substr ( $telefone, 7);
        return "($ddd) $parte1-$parte2";
}