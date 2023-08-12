<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Porcentajes.php");
   require_once("../../../Controlador/ControladorPorcentajes.php");
   
   $data = ControladorPorcentajes::getPorcentaje();

   print json_encode($data, JSON_UNESCAPED_UNICODE);