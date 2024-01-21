<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Venta.php");
require_once("../../../Controlador/ControladorVenta.php");

$numFactura = $_POST['numFactura'];
$estadoEliminado = ControladorVenta::eliminarVenta($numFactura);
print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);