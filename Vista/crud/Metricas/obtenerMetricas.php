<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Metricas.php");
   require_once("../../../Controlador/ControladorMetricas.php");
   
   $data = ControladorMetricas::obtenerMetricas();

   print json_encode($data, JSON_UNESCAPED_UNICODE);