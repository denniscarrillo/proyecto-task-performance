<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = null;
    $usuario = false;
    $intentosMax = intval(ControladorUsuario::intentosLogin());

    if(isset($_POST["submit"])){
        if(empty($_POST["userName"]) or empty($_POST["userPassword"])){
            $mensaje = 'Debe llenar ambos campos';
        } else {
            $usuario = ControladorUsuario::login($_POST["userName"], $_POST["userPassword"]);
            if($usuario){
                header('location: ../index.php');
            } 
            else {
                $intentosFallidos = ControladorUsuario::intentosFallidos($_POST["userName"]);
                $incremento = ControladorUsuario::incrementarIntentos($_POST["userName"], $intentosFallidos);
                $nuevoEstado = Usuario::bloquearUsuario($intentosMax, $incremento, $_POST["userName"]);
                //Si el estado es bloqueado muestra el mensaje
                if ($nuevoEstado) {
                    $mensaje = 'Usuario bloqueado';
                } else {
                    $mensaje = 'Usuario y/o Contraseña invalidos - Intentos: '. $incremento;
                }
            }
        }
    }


