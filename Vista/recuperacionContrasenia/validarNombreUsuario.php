<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = null;
    $usuario = false;

    if(isset($_POST["submit"])){
        if(empty($_POST["userName"])){
            $mensaje = 'Debe llenar el campo Usuario';
        } else {
            $usuario = ControladorUsuario::existeUsuario($_POST["userName"]);
            if($usuario >0){
                header('location: ../login/preguntasResponder.php');
            } else {
                $mensaje = 'Usuario inválido';
            }
        }
    }

    