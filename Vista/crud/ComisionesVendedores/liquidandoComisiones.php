<?php
// En tu archivo PHP

require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Comision.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorComision.php");

if(isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])){
    $fechaDesde = $_POST['fechaDesde'];
    $fechaHasta = $_POST['fechaHasta'];
    ControladorComision::liquidandoComisiones($fechaDesde, $fechaHasta);
}
?>


       


    