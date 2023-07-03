<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("enviarCorreo.php");

    $opcion = '';
    $user = '';
    $existe = '';
    if(isset($_POST['radioOption'])){
        $opcion = $_POST['radioOption'];
    }
    if(isset($_POST['submit'])){
        if(isset($_POST['userName'])){
            $user = $_POST['userName'];
            $existe = ControladorUsuario::obCorreoUsuario($user);
            if($existe != ''){
                //Generamos el token
                $bytes = random_bytes(16);
                $token = bin2hex($bytes);
                //Almacenar token en la base de datos correspondiente al usuario
                

                $correo = $existe;
                $mensaje = enviarCorreo($correo, $token);
            }
        }
    }