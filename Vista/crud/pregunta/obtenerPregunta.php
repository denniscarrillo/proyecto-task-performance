<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Pregunta.php");
   require_once("../../../Controlador/ControladorPregunta.php");
   
   $data = ControladorPregunta::preguntasUsuario();

   print json_encode($data, JSON_UNESCAPED_UNICODE);