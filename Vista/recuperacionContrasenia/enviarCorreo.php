<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../librerias/PHPMailer/Exception.php';
require '../../librerias/PHPMailer/PHPMailer.php';
require '../../librerias/PHPMailer/SMTP.php';

function enviarCorreo($destinario, $token){
    $confirmacion = '';
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'oaoproyecto@gmail.com';                //SMTP username
        $mail->Password   = 'xduwptjwdzdbbxav';                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('oaoproyecto@gmail.com', 'Cocinas&Equipos');
        $mail->addAddress($destinario);                             //Add a recipient
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Has iniciado el proceso de recuperación de contraseña';
        $mail->Body    = 
        '<div>
            <h2>Este es tu token de recuperacion</h2>
            <p><b>'.$token.'</b></p>
        </div>';
        // $mail->AltBody = 'Si funcionó!';
        $mail->send();
        $confirmacion = 'Se te ha enviado un token, verifica tu correo electrónico';
    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar el mensaje. Mailer Error: {$mail->ErrorInfo}';
    }
    return $confirmacion;
}

