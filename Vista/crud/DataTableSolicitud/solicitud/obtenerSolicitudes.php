<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Solicitud.php");
   require_once("../../../Controlador/ControladorSolicitud.php");
   
   $data = ControladorSolicitud::getSolicitudes();

   print json_encode($data, JSON_UNESCAPED_UNICODE);
