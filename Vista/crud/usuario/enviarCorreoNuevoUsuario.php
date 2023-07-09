<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../librerias/PHPMailer/Exception.php';
require '../../../librerias/PHPMailer/PHPMailer.php';
require '../../../librerias/PHPMailer/SMTP.php';

function enviarCorreoNuevoUsuario($destinario, $usuario, $contrasenia){
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
        $mail->Subject = 'Creación de cuenta para poder acceder al sistema Equipos&Cocinas';
        $mail->Body    = 
        '<div>
            <h2>Se le notifica que ha sido creada su cuenta con éxito</h2>
            <h1>Ahora puede iniciar sesión</h1>
            <p><b> Usuario:'.$usuario.'</b></p>
            <p><b> Contraseña:'.$contrasenia.'</b></p>
        </div>';
        // $mail->AltBody = 'Si funcionó!';
        $mail->send();
        $confirmacion = 'El usuario debe verificar su correo electrónico';
    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar el mensaje. Mailer Error: {$mail->ErrorInfo}';
    }
    return $confirmacion;
}

