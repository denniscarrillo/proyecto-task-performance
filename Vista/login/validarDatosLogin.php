<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = null;
    $usuario = false;

    if(isset($_POST["submit"])){
        if(empty($_POST["userName"]) or empty($_POST["userPassword"])){
            $mensaje = 'Debe llenar ambos campos';
        } else {
            $usuario = ControladorUsuario::login($_POST["userName"], $_POST["userPassword"]);
            if($usuario){
                header('location: ../index.php');
            } else {
                $mensaje = 'Usuario/contraseña inválidos';
            }
        }
    }


