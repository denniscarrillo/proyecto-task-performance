<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../librerias/PHPMailer/Exception.php';
require '../../../librerias/PHPMailer/PHPMailer.php';
require '../../../librerias/PHPMailer/SMTP.php';

function enviarCorreoSolicitud($destinario){
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
        $mail->Username   = $getDataServerEmail[1]['valorParametro'];                //SMTP username
        $mail->Password   = $getDataServerEmail[2]['valorParametro'];                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = intval($getDataServerEmail[3]['valorParametro']);  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

       //Recipients
       $mail->setFrom($getDataServerEmail[1]['valorParametro'], $getDataServerEmail[0]['valorParametro']);
       $mail->addAddress($destinario);                             //Add a recipient
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Nueva Solicitud';
        $mail->Body    = 
        '<div>
            <h2>Se le envia informacion acerca de la nueva solicitud</h2>
        </div>';
        // $mail->AltBody = 'Si funcionó!';
        $mail->CharSet = 'UTF-8'; // Setear UTF-8 para caracteres especiales
        $mail->send();
        $confirmacion = 'La solicitud de se ha enviado al correo electrónico';
    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar la solicitud. Mailer Error: {$mail->ErrorInfo}';
    }
    return $confirmacion;
}

