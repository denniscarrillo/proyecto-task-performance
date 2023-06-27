<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    $nombreUsuario = null;
    $mensaje = null;
    $usuario = false;
    $nuevoEstado = false;
    $estadoUsuario = null;
    $intentosMax = intval(ControladorUsuario::intentosLogin());
    if(isset($_POST["submit"])){
        // session_start();
        $_SESSION['usuario'] = null;
        // session_destroy();
        $nombreUsuario = $_POST["userName"];
        $intentosFallidos = ControladorUsuario::intentosFallidos($_POST["userName"]);
        $estadoUsuario = ControladorUsuario::estadoUsuario($_POST["userName"]);
        if(empty($_POST["userName"]) or empty($_POST["userPassword"])){
            $mensaje = 'Debe llenar ambos campos';
        } else {
            $existeUsuario = ControladorUsuario::login($_POST["userName"], $_POST["userPassword"]);
            if($existeUsuario){
                $_SESSION['usuario'] = $_POST["userName"];
                switch($estadoUsuario){
                    case 1:
                        if($intentosFallidos > 0){
                            ControladorUsuario::resetearIntentos($_POST["userName"]);
                        }
                        header('location: configPreguntas.php');
                     break; 
                    case 2:
                        if($intentosFallidos > 0){
                            ControladorUsuario::resetearIntentos($_POST["userName"]);
                        }
                        header('location: ../crud/gestionUsuario.php');
                     break; 
                    case 3:
                     $mensaje = 'Usuario Inactivo';
                     break; 
                    case 4:
                     $mensaje = 'Usuario bloqueado';
                     break;      
                }
            } else {
                if ($intentosFallidos == null){
                    $mensaje = 'Usuario no existe';
                } else {
                    $incremento = ControladorUsuario::incrementarIntentos($_POST["userName"], $intentosFallidos);
                    $nuevoEstado = Usuario::bloquearUsuario($intentosMax, $incremento, $_POST["userName"]); 
                    if($nuevoEstado == true || $estadoUsuario == 4){
                        $mensaje = 'Usuario bloqueado';
                    }  else {
                        $mensaje = 'Usuario y/o Contraseña invalidos';
                    }  
                }
            }
        }
    }
    require_once("validarPreguntas.php");