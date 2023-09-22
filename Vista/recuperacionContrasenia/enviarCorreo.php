<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../librerias/PHPMailer/Exception.php';
require '../../librerias/PHPMailer/PHPMailer.php';
require '../../librerias/PHPMailer/SMTP.php';

function enviarCorreo($destinario, $token){
    $confirmacion = '';
    $getDataServerEmail = ControladorParametro::getDataServerEmail();
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $getDataServerEmail[0]['valorParametro'];                //SMTP username
        $mail->Password   = $getDataServerEmail[3]['valorParametro'];                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = $getDataServerEmail[1]['valorParametro'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($getDataServerEmail[0]['valorParametro'], $getDataServerEmail[2]['valorParametro']);
        $mail->addAddress($destinario);                             //Add a recipient
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Hola!';
        $mail->Body    = 
        '<div>
        <h1> Ha iniciado el metodo de recuperacion de contrasenia </h1>
        <p> Hola, usted ha solicitado un cambio de contrasenia, le hemos enviado un token, copielo y peguelo en el siguiente formulario. </p> <br>
            <h2 style="text-align: center;>Este es su token de recuperacion</h2>
            <p style="text-align: center; font-size: 25px;"><b>'.$token.'</b></p>
            <br>
        <p> Este token solo sera valido dentro de las proximas 24 hrs. </p>
        <br>
        <p> Saludos, </p>
        <p> Cocina y Equipos </p>
        </div>';
        $mail->CharSet = 'UTF-8'; // Setear UTF-8 para caracteres especiales
        $mail->send();
        $confirmacion = 'Se te ha enviado un token, verifica tu correo electrónico';
    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar el mensaje. Mailer Error: {$mail->ErrorInfo}';
    }
    return $confirmacion;
}

