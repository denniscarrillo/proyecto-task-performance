<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/VistaClientes.php");
   require_once("../../../Controlador/ControladorVistaClientes.php");
   
   $data = ControladorVistaClientes::getClientes();

   print json_encode($data, JSON_UNESCAPED_UNICODE);