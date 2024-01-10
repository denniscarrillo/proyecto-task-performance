<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/RazonSocial.php");
    require_once("../../../Controlador/ControladorRazonSocial.php");
   
   $data = ControladorRazonSocial::getRazonSocial();

   print json_encode($data, JSON_UNESCAPED_UNICODE);