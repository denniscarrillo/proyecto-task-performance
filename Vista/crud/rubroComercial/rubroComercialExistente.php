<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/RubroComercial.php");
require_once("../../../Controlador/ControladorRubroComercial.php");


session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $existe = array();
    $estadoClienteC = ControladorRubroComercial::RubroComercialExiste($_POST['rubroComercial']);
    print json_encode($estadoClienteC, JSON_UNESCAPED_UNICODE);
}