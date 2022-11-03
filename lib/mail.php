<?php
//smtp

//Senha
//Email
//host
//porta

use PHPMailer\PHPMailer\PHPMailer;

function enviar_email($destinatario, $assunto, $mensagemHTML)
{
    require 'vendor/autoload.php';

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = '';
    $mail->Port = 000;
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';

    $mail->SMTPSecure = false;
    $mail->isHTML(true);
    $mail->CharSet('UTF-8');

    $mail->setFrom('email', 'name');
    $mail->AddAddress($destinatario);
    $mail->Subject = $assunto;

    $mail->Body = $mensagemHTML;

    if($mail->send()){  
        return true;
    } else {
        return false;
    }
}
?>