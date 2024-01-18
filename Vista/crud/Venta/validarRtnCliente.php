<?php
require_once('../../../db/Conexion.php');
require_once('../../../Modelo/Venta.php');
require_once('../../../Controlador/ControladorVenta.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $existe = array();
    $estadoClienteC = ControladorVenta::validarClienteExistenteCarteraCliente($_POST['rtnCliente']);
    print json_encode($estadoClienteC, JSON_UNESCAPED_UNICODE);
    // $existe = [
    //     'estado' => 'true'
    // ];  
    // print json_encode($existe, JSON_UNESCAPED_UNICODE);
}