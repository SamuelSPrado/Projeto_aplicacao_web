<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "crud_cliente";

$mysqli = new mysqli($host, $user, $password, $database);
if($mysqli->connect_errno){
    die("Houve uma falha em sua conexão!");
}