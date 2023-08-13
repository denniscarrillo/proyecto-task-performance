<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Articulo.php");
   require_once("../../../Controlador/ControladorArticulo.php");
   
   $data = ControladorArticulo::obtenerTodosArticulos();

   print json_encode($data, JSON_UNESCAPED_UNICODE);