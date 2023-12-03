<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/RubroComercial.php");
    require_once("../../../Controlador/ControladorRubroComercial.php");
   
   $data = ControladorRubroComercial::getRubroComercial();

   print json_encode($data, JSON_UNESCAPED_UNICODE);