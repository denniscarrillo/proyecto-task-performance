<?php
require_once '../../db/Conexion.php';
require_once '../../Modelo/Comision.php';
require_once '../../Controlador/ControladorComision.php';

$estadoComisiones = ControladorComision::trayendoEstadoComision();
print json_encode($estadoComisiones, JSON_UNESCAPED_UNICODE);