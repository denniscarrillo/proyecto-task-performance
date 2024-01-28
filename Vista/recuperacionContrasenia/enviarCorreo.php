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
        $mail->Username   = $getDataServerEmail['ADMIN_CORREO'];                //SMTP username
        $mail->Password   = $getDataServerEmail['ADMIN_PASSWORD'];                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = intval($getDataServerEmail['ADMIN_PUERTO']);  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($getDataServerEmail['ADMIN_CORREO'], $getDataServerEmail['ADMIN_USER']);
        $mail->addAddress($destinario);                             //Add a recipient
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Has iniciado el proceso de recuperación';
        $mail->Body = '
        <div style="background-color: #fff; border-radius: 20px; padding: 20px; max-width: 600px; margin: auto; font-family: Arial, sans-serif; color: #000; text-align: left; margin-left: 0;">
            <h1 style="color: #000;">Recuperación de contraseña</h1>
            <p style="font-size: 16px; color: #000;">Hola, has iniciado el proceso de restablecer tu contraseña. Te hemos enviado un token para validar tu identidad.</p>
            <p style="font-size: 16px; color: #000;">Por favor, cópialo e ingrésalo en el formulario de validación para continuar con el proceso.</p>
            
            <div style="background-color: #000; color: #fff; padding: 15px; border-radius: 10px; margin-top: 20px;">
                <h2 style="color: #fff;">Este es tu token de recuperación:</h2>
                <h1 style="background-color: #fff; padding: 10px; border-radius: 10px; color: #000; margin: 10px 0;">'.$token.'</h1>
                <p style="font-size: 14px; color: #fff;">Este token expirará en '.$horasVigencia.' horas.</p>
            </div>
            
            <p style="font-size: 16px; margin-top: 20px;">Saludos,<br>Task Performance</p>
        </div>';
        $mail->CharSet = 'UTF-8'; // Setear UTF-8 para caracteres especiales
        if(!$mail->Send()) {
            $confirmacion = false;
          } else {
            $confirmacion = true;
          }
          return $confirmacion;
    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar el mensaje Mailer Error: '.$mail->ErrorInfo;
    }
}