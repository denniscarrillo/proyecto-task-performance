<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("enviarCorreo.php");

    $opcion = '';
    $user = '';
    $existe = '';
    $mensaje = '';
    if(isset($_POST['radioOption'])){
        $opcion = $_POST['radioOption'];
    }
    if(isset($_POST['submit'])){
        if(isset($_POST['userName'])){
            $user = $_POST['userName'];
            $existe = ControladorUsuario::obCorreoUsuario($user);
            if($existe != ''){
                //Generamos el token
                // $bytes = random_bytes(16);
                // $token = bin2hex($bytes);
                $token = random_int(1000, 9999);

                //Almacenar token en la base de datos correspondiente al usuario
                $almacenado = ControladorUsuario::almacenarToken($user, $token);
                if($almacenado){
                    $correo = $existe;
                    $mensaje = enviarCorreo($correo, $token);
                    header("location:v_SolicitarToken.php");
                }
            } else {
                $mensaje = "No existe el usuario";
            }
        } 
    }