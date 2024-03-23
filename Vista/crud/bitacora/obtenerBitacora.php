<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Bitacora.php");
   require_once("../../../Controlador/ControladorBitacora.php");
   
   $data = ControladorBitacora::bitacorasUsuario($_POST['fechaDesde'], $_POST['fechaHasta']);

   print json_encode($data, JSON_UNESCAPED_UNICODE);