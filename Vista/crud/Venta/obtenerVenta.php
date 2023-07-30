<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Ventas.php");
   require_once("../../../Controlador/ControladorVentas.php");
   
   $data = ControladorVenta::getVentas();

   print json_encode($data, JSON_UNESCAPED_UNICODE);