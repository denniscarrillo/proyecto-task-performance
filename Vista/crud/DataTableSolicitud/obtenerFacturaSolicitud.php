<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Venta.php");
   require_once("../../../Controlador/ControladorVenta.php");
   
   session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $clientesTarea = ControladorVenta::getVentas();
    print json_encode($clientesTarea, JSON_UNESCAPED_UNICODE);
}   