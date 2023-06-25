<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = null;
    $usuario = false;
    $nuevoEstado = false;
    $intentosMax = intval(ControladorUsuario::intentosLogin());

    if(isset($_POST["submit"])){
        $intentosFallidos = ControladorUsuario::intentosFallidos($_POST["userName"]);
        if(empty($_POST["userName"]) or empty($_POST["userPassword"])){
            $mensaje = 'Debe llenar ambos campos';
        } else {
            $existeUsuario = ControladorUsuario::login($_POST["userName"], $_POST["userPassword"]);
            if($existeUsuario){
                $estadoBloqueado = ControladorUsuario::estadoUsuario($_POST["userName"]);
                if($estadoBloqueado == ($intentosMax +1)){
                    $mensaje = 'Usuario bloqueado';
                } else {
                    if($intentosFallidos > 0){
                        ControladorUsuario::resetearIntentos($_POST["userName"]);
                    }
                    header('location: ../crud/gestionUsuario.php');
                }
            } else {
                if ($intentosFallidos == null){
                    $mensaje = 'Usuario no existe';
                } else {
                    $incremento = ControladorUsuario::incrementarIntentos($_POST["userName"], $intentosFallidos);
                    $nuevoEstado = Usuario::bloquearUsuario($intentosMax, $incremento, $_POST["userName"]); 
                    if($nuevoEstado == true || $intentosFallidos == ($intentosMax + 1)){
                        $mensaje = 'Usuario bloqueado';
                    }  else {
                        $mensaje = 'Usuario y/o Contraseña invalidos - Intentos: '. $incremento;
                    }  
                }
            }
        }
    }