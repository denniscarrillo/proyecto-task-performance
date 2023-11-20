<?php
// En tu archivo PHP

require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Comision.php");
require_once("../../../Controlador/ControladorComision.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fechaDesde = isset($_POST['fechaDesde']) ? $_POST['fechaDesde'] : null;
    $fechaHasta = isset($_POST['fechaHasta']) ? $_POST['fechaHasta'] : null;

    if ($fechaDesde !== null && $fechaHasta !== null) {
        $mensaje = ControladorComision::liquidandoComisiones($fechaDesde, $fechaHasta);
        print json_encode(['success' => true, 'message' => $mensaje], JSON_UNESCAPED_UNICODE);
    }
}

?>


       


    