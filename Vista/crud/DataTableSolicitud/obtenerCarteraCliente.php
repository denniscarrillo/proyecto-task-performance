<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/CarteraClientes.php");
   require_once("../../../Controlador/ControladorCarteraClientes.php");
   
   $data = ControladorCarteraClientes::obtenerCarteraClientes();

   print json_encode($data, JSON_UNESCAPED_UNICODE);