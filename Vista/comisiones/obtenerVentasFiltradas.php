<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Venta.php");
require_once("../../Controlador/ControladorVenta.php");

$ventas = ControladorVenta::traerVentasPorFechas($_POST['fecha_Desde'], $_POST['fecha_Hasta']);
if(count($ventas) > 0){
    print json_encode($ventas, JSON_UNESCAPED_UNICODE);
}
