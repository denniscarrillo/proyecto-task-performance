<?php
require('../../db/Conexion.php');
require_once ("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");

$user = '';
session_start(); //Reanudar sesion
if(isset($_SESSION['usuario'])){
    $user = $_SESSION['usuario'];
}

$mensaje = "";
if (isset($_POST['submit'])){
    $token =$_POST['token'];
    $estadoToken = ControladorUsuario::validarTokenUsuario($user, $token);
    if( $estadoToken ){
        header('location: v_nuevaContrasenia.php');
    } else {
        $mensaje= "Token no válido o incorrecto";
    }
}
