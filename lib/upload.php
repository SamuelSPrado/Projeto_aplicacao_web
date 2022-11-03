<?php

function enviarArquivo(
    $error, 
    $size, 
    $name, 
    $tmp_name)
{
    if($error)
        die("Falha ao enviar arquivo");

    if($size > 2097152) //2MB
        die("Tamanho máximo de até 2MB");
    
    $pasta = "arquivos/";
    $nomeDoArquivo = $name;
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(
        pathinfo(
            $nomeDoArquivo, 
            PATHINFO_EXTENSION)
        );

    if($extensao != "jpg" && $extensao != 'png')
        die("Formato inválido");
    
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $sucesso = move_uploaded_file(
        $tmp_name, 
        $path
    );

    if($sucesso)
    {
        return $path;
    }
    else
        return false;
}