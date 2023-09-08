<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/DataTableObjeto.php");
   require_once("../../../Controlador/ControladorDataTableObjeto.php");
  
      $data = ControladorDataTableObjeto::DataTableObjeto();
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   