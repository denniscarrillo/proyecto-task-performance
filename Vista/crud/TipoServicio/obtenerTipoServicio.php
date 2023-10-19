<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/TipoServicio.php");
   require_once("../../../Controlador/ControladorTipoServicio.php");
   
   $data = ControladorTipoServicio::obtenerTipoServicio();

   print json_encode($data, JSON_UNESCAPED_UNICODE);