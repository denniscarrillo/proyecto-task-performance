<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   
   if(isset($_GET['IdUsuario'])){
      $data = ControladorUsuario::obtenerUsuariosPorId($_GET['IdUsuario']);
      print json_encode($data, JSON_UNESCAPED_UNICODE);
   }
