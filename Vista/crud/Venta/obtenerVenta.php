<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Venta.php");
   require_once("../../../Controlador/ControladorVenta.php");
   
   $data = ControladorVenta::getVentas();

   print json_encode($data, JSON_UNESCAPED_UNICODE);