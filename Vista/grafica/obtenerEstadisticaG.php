<?php
   require_once ("../../db/Conexion.php");
   require_once ("../../Modelo/Metricas.php");
   require_once("../../Controlador/ControladorMetricas.php");



if(isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])){

   $data = ControladorMetricas::obtenerEstadisticasGeneral($_POST['fechaDesde'], $_POST['fechaHasta']);
   //$data = ControladorMetricas::obtenerEstadisticasGeneral($FechaInicial, $FechaFinal);

   print json_encode($data, JSON_UNESCAPED_UNICODE);
}