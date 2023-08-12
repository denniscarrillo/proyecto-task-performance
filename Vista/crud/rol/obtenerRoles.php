<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Rol.php");
   require_once("../../../Controlador/ControladorRol.php");
   
   $data = ControladorRol::rolesUsuario();

   print json_encode($data, JSON_UNESCAPED_UNICODE);