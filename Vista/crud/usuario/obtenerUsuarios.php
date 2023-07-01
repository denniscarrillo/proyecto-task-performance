<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   
   $data = ControladorUsuario::getUsuarios();

   print json_encode($data, JSON_UNESCAPED_UNICODE);
