<?php
session_start(); //Reanudar sesion
require_once('../../db/Conexion.php');
require_once ("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");

$user = '';
$tokenSend = 0;
$mensaje = "";
if(isset($_SESSION['tokenSend'])){ //Cuando venimos de registro capturamos el valor para saberlo
    $tokenSend  = $_SESSION['tokenSend'];
    /*
        Ahora eliminamos esa variable global para que el Toast que se muestra con javascript 
        no se vuelva a mostrar cuando la pagina se refresque por cualquier motivo
    */
    $_SESSION['tokenSend'] = 0;
}
if(isset($_SESSION['usuario'])){
    $user = $_SESSION['usuario'];
    if (isset($_POST['submit'])){
        if(!empty($_POST['token'])) {
            $token = $_POST['token'];
            $estadoToken = ControladorUsuario::validarTokenUsuario($user, $token);
            switch($estadoToken){
                case 0: {
                    $mensaje = "El token ingresado es incorrecto";
                    break;
                }
                case 1: {
                    $mensaje = "Este token ha expirado";
                    break;
                }
                case 2: {
                    header('location: v_nuevaContrasenia.php');
                    
                    break;
                }
            }
        } else {
            $mensaje = "Debe digitar un token!";
        }
    }
}else{
    header("Location: ../login/login.php");
    exit(); // Asegurarse de que el script termine aquí
}

