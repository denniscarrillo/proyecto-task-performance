<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Metricas.php");
require_once("../../Controlador/ControladorMetricas.php");


$Metricas = ControladorMetricas::obtenerMetaMetricas();
print json_encode($Metricas, JSON_UNESCAPED_UNICODE);


