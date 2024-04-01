<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/RazonSocial.php");
require_once("../../../Controlador/ControladorRazonSocial.php");


session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $existe = array();
    $estadoClienteC = ControladorRazonSocial::RazonSocialExiste($_POST['razonSocial']);
    print json_encode($estadoClienteC, JSON_UNESCAPED_UNICODE);
}

