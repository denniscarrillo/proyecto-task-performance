<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Porcentajes.php");
require_once("../../../Controlador/ControladorPorcentajes.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorBitacora.php");

$user = '';
$eliminar = '';
session_start();

if (isset($_SESSION['usuario'])) {
    $user = $_SESSION['usuario'];
    $eliminarPorcentaje = new Porcentajes();
    $eliminarPorcentaje->idPorcentaje = $_POST['idPorcentaje'];
    $eliminarPorcentaje->estadoPorcentaje = $_POST['estado'];
    $eliminarPorcentaje->ModificadoPor = $user;
    date_default_timezone_set('America/Tegucigalpa');
    $eliminarPorcentaje->fechaModificacion = date("Y-m-d");

    // Verificar si el porcentaje ya se ha utilizado en una comisión
    $esUtilizado = ControladorPorcentajes::verificarUtilizacionEnComision($eliminarPorcentaje->idPorcentaje);

    if ($esUtilizado) {
        // Si el porcentaje ya se utilizó, inactivarlo
        ControladorPorcentajes::inactivarPorcentaje($eliminarPorcentaje);
        echo json_encode('INACTIVO');
    } else {
        // Si el porcentaje no se ha utilizado, eliminarlo
        ControladorPorcentajes::eliminarPorcentaje($eliminarPorcentaje);
        echo json_encode('ELIMINADO');
    }
        /* ========================= Evento Eliminar porcentaje. ====================================*/  
if($esUtilizado){
    $eliminar = " eliminó ";
}else{
    $eliminar = " intentó eliminar ";
}
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionPorcentajes.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Delete'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' eliminó el porcentaje #' . '' . $_POST['idPorcentaje'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
}


