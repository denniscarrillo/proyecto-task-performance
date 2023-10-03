<?php
require_once('../../db/Conexion.php');
require_once ("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");

$user = '';
session_start(); //Reanudar sesion
if(isset($_SESSION['usuario'])){
    $user = $_SESSION['usuario'];
}
$mensaje = "";
if (isset($_POST['submit'])){
    if(!empty($_POST['token'])) {
        $token = $_POST['token'];
        $estadoToken = ControladorUsuario::validarTokenUsuario($user, $token);
        switch($estadoToken){
            case 0: {
                $mensaje = "Token inválido/incorrecto";
                break;
            }
            case 1: {
                $mensaje = "Su token ha expirado";
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
