<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $vendedoresTarea = ControladorUsuario::obtenerVendedores($idTarea);
    print json_encode($vendedoresTarea, JSON_UNESCAPED_UNICODE);
}