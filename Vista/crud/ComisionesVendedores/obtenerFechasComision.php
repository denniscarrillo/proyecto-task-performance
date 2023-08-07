<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Comision.php");
   require_once("../../../Controlador/ControladorComision.php");

   if(isset($_POST['fecha_Desde'])){
    $totalComision = ControladorComision::obtenerSumaComisionesVendedores($_POST['fecha_Desde'], $_POST['fecha_Hasta']);
       print json_encode($totalComision, JSON_UNESCAPED_UNICODE);
   }