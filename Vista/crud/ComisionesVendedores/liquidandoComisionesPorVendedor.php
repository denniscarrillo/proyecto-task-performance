<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Comision.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorComision.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST['idVendedores'], $_POST['fechaDesde'], $_POST['fechaHasta'])) {
    $idVendedores = $_POST['idVendedores'];
    $fechaDesde = $_POST['fechaDesde'];
    $fechaHasta = $_POST['fechaHasta'];

    // Llamar a la función para liquidar comisiones por vendedor para múltiples vendedores
    foreach ($idVendedores as $idVendedor) {
        ControladorComision::LiquidandoComisionesVendedores($idVendedor, $fechaDesde, $fechaHasta);
    }

    // Puedes devolver una respuesta si es necesario
    echo json_encode(['success' => true, 'message' => 'Comisiones liquidadas correctamente']);
} else {
    // Manejar el caso en el que no se proporcionan los ID de los vendedores o las fechas
    echo json_encode(['success' => false, 'message' => 'Error: No se proporcionaron los ID de los vendedores o las fechas.']);
}
?>




