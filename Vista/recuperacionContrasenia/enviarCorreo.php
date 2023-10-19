<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../librerias/PHPMailer/Exception.php';
require '../../librerias/PHPMailer/PHPMailer.php';
require '../../librerias/PHPMailer/SMTP.php';

function enviarCorreo($destinario, $token, $horasVigencia){
    $confirmacion = false;
    $getDataServerEmail = ControladorParametro::getDataServerEmail();
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $getDataServerEmail[1]['valorParametro'];                //SMTP username
        $mail->Password   = $getDataServerEmail[2]['valorParametro'];                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = intval($getDataServerEmail[3]['valorParametro']);  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($getDataServerEmail[1]['valorParametro'], $getDataServerEmail[0]['valorParametro']);
        $mail->addAddress($destinario);                             //Add a recipient
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Has iniciado el proceso de recuperación';
        $mail->Body    = 
        '<div style="background-color: #dc6414; border-radius: 4rem; padding: 2rem;">
        <h1> Recuperación de contraseña </h1>
        <p style="font-size: 3rem;"> Hola, usted ha iniciado el proceso de restablecer contraseña, le hemos enviado este token.</p>
        <p style="font-size: 3rem;"> Cópielo e ingréselo en el formulario de Validación para poder continuar con el proceso </p>
            <h2>Este es su token de recuperación</h2>
            <h1> ============== <b>'.$token.'</b> ==============</h1>
        <h3> ----------------------- Este token expirará dentro de '.$horasVigencia.' hrs ---------------------</h3>
        <p> Saludos, Cocinas y Equipos</p>
        </div>';
        $mail->CharSet = 'UTF-8'; // Setear UTF-8 para caracteres especiales
        if(!$mail->Send()) {
            $confirmacion = false;
          } else {
            $confirmacion = true;
          }

    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar el mensaje Mailer Error: '.$mail->ErrorInfo;
    }
    return $confirmacion;
}

