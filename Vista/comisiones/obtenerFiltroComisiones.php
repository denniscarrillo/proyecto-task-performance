<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Comision.php");
require_once("../../Controlador/ControladorComision.php");

$comision = '';
if(isset($_REQUEST['fechaDesde']) && isset($_REQUEST['fechaHasta'])){
    $fechaDesde = $_REQUEST['fechaDesdef'];
    $fechaHasta = $_REQUEST['fechaHastaf'];
    $fechas = ControladorComision::obtenerFechasComisiones($_POST['fechaDesdef'], $_POST['fechaHastaf']);
}