<?php
   require_once ("../../db/Conexion.php");
   require_once ("../../Modelo/Comision.php");
   require_once("../../Controlador/ControladorComision.php");

   if(isset($_POST['fecha_Desde']) && isset($_POST['fecha_Hasta'])){
    $fechasComisiones = ControladorComision::ComisionesGenerales_a_Liquidar($_POST['fecha_Desde'], $_POST['fecha_Hasta']);
       print json_encode($fechasComisiones, JSON_UNESCAPED_UNICODE);
   }