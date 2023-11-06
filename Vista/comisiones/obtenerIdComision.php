<?php
   require_once ("../../db/Conexion.php");
   require_once ("../../Modelo/Comision.php");
   require_once("../../Controlador/ControladorComision.php");
   
   
   if(isset($_GET['IdComision'])){
      $data = ControladorComision::traerIdComision($_GET['IdComision']);
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }