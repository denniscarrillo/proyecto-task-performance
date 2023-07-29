<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Venta.php");
require_once("../../Controlador/ControladorVenta.php");
// $ventas = array();

if(isset($_POST['fecha_Desde'])){
    $ventas = ControladorVenta::traerVentasPorFechas($_POST['fecha_Desde'], $_POST['fecha_Hasta']);
    print json_encode($ventas, JSON_UNESCAPED_UNICODE);
}