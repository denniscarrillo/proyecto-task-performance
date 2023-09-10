<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Comision.php");
require_once ("../../../Controlador/ControladorComision.php");

$data = ControladorComision::getComision();

print json_encode($data, JSON_UNESCAPED_UNICODE);