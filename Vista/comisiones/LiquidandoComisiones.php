<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Comision.php');
require_once('../../Controlador/ControladorComision.php');

if (isset($_POST['idComision'])) {
    // Obtén el ID de la comisión desde la solicitud POST
    $idComision = $_POST['idComision'];

    // Llama a la función para liquidar la comisión
    ControladorComision::liquidandoComisionesGenerales($idComision);
} else {
    // Manejo de error si no se proporciona el ID de la comisión
    echo "Error: No se proporcionó el ID de la comisión.";
}
