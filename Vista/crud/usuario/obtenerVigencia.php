<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Parametro.php");
   require_once("../../../Controlador/ControladorParametro.php");
   
   $data = ControladorParametro::obtenerVigencia();

   print json_encode($data, JSON_UNESCAPED_UNICODE);