<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/DataTableSolicitud.php");
   require_once("../../../Controlador/ControladorDataTableSolicitud.php");
   
   
   if(isset($_GET['IdSolicitud'])){
      $data = ControladorDataTableSolicitud::LlenarModalSolicitudEditar($_GET['IdSolicitud']);
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }