<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Articulo.php");
   require_once("../../../Controlador/ControladorArticulo.php");

   if(isset($_POST['codArticulo'])) {
      $data = ControladorArticulo::obtenerPreciosProductoPorID($_POST['codArticulo']);
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }
   
   