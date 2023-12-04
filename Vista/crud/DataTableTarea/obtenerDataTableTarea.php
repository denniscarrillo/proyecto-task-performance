<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/DataTableTarea.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once("../../../Controlador/ControladorDataTableTarea.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   session_start();
   if(isset($_SESSION['usuario'])){
      $rolUsuario = ControladorUsuario::obtenerRolUser($_SESSION['usuario']);
      $data = ControladorDataTableTarea::obtenerTareasUsuario($_SESSION['usuario'], $rolUsuario);
      // var_dump($data);
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }
   
  