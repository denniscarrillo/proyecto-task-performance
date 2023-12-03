<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/EstadoUsuario.php");
   require_once("../../../Controlador/ControladorEstadoUsuario.php");
   
   $data = ControladorEstadoUsuario::obtenerEstadoUsuario();

   print json_encode($data, JSON_UNESCAPED_UNICODE);