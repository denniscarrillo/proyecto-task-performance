<?php
// En tu archivo PHP

require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Comision.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorComision.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Resto del código PHP

if (isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])) {
    try {
        $fechaDesde = $_POST['fechaDesde'];
        $fechaHasta = $_POST['fechaHasta'];
        
        // Verifica que las fechas no estén vacías antes de ejecutar la lógica
        if (!empty($fechaDesde) && !empty($fechaHasta)) {
            ControladorComision::liquidandoComisiones($fechaDesde, $fechaHasta);
            $response = array('success' => true, 'message' => 'Comisiones liquidadas correctamente');
            
        } else {
            $response = array('success' => false, 'message' => 'Error: Las fechas no están definidas o son inválidas.');
        }
    } catch (Exception $e) {
        $response = array('success' => false, 'message' => 'Error: ' . $e->getMessage());
    }

    // Retorna la respuesta como JSON
    echo json_encode($response);
} else {
    // Si las claves no están definidas, devuelve un mensaje de error
    echo json_encode(array('success' => false, 'message' => 'Error: Las claves "fechaDesde" y "fechaHasta" no están definidas en $_POST.'));
}

?>
