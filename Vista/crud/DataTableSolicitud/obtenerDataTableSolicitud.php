<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/DataTableSolicitud.php");
   require_once("../../../Controlador/ControladorDataTableSolicitud.php");
   
   session_start();
   if(isset($_SESSION['usuario'])){
      
      $data = ControladorDataTableSolicitud::DataTableSolicitud($_SESSION['usuario']);
      
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }