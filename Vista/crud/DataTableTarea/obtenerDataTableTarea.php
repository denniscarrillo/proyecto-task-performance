<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/DataTableTarea.php");
   require_once("../../../Controlador/ControladorDataTableTarea.php");
   session_start();
   if(isset($_SESSION['usuario'])){
      $data = ControladorDataTableTarea::obtenerTareasUsuario($_SESSION['usuario']);
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }
   
  