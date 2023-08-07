<?php
require_once("../../db/Conexion.php");
require_once("../../Modelo/Comision.php");
require_once("../../Controlador/ControladorComision.php");

if (isset($_POST['totalVenta'])) {
    $porcentajes = ControladorComision::traerPorcentajesComision();
    foreach ($porcentajes as $porcentaje) {
        if ($porcentaje['idPorcentaje'] == $_POST['porcentaje']) {
            $porcentaje = $porcentaje['porcentaje'];
            $comision = ControladorComision::calcularComisionTotal(floatval($porcentaje), floatval($_POST['totalVenta']));
           /*  $dividirComision = ControladorComision::divisionDeComisiones(floatval($comision[0]['comision']), $_POST['vendedores']); */
            print json_encode($comision, JSON_UNESCAPED_UNICODE);
        }

    }
}