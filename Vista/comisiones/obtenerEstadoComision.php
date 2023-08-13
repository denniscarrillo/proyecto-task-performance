<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Comision.php");
require_once("../../Controlador/ControladorComision.php");
if(isset ($_POST['idVenta'])){
$estadoComision = ControladorComision::traerEstadoComision($_POST['idVenta']);
$estadoVenta = array();
if($estadoComision == true){
    $estadoVenta = [
        "estado" => "true"
    ];
}else{
    $estadoVenta = [
        "estado" => "false"
    ];
}
print json_encode($estadoVenta, JSON_UNESCAPED_UNICODE);
}