<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Permiso.php");
   require_once("../../../Controlador/ControladorPermiso.php");
   
   $data = ControladorPermiso::obtenerPermisosSistema();

   print json_encode($data, JSON_UNESCAPED_UNICODE);