<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Comision.php");
require_once("../../Controlador/ControladorComision.php");

if(isset($_POST['idFacturaVenta'])){
    $idTarea = ControladorComision::traerIdTarea($_POST['idFacturaVenta']);
    $vendedores = ControladorComision::traerVendedores($idTarea);
    print json_encode($vendedores, JSON_UNESCAPED_UNICODE);
}