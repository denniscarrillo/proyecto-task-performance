<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Rol.php");
require_once("../../../Controlador/ControladorRol.php");

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $existe = array();
    $estado = ControladorRol::rolExiste($_POST['rol']);
    print json_encode($estado, JSON_UNESCAPED_UNICODE);

}