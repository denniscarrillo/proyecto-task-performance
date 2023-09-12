<?php
require_once("../../db/Conexion.php");
require_once("../../Modelo/Comision.php");
require_once("../../Modelo/Bitacora.php");
require_once("../../Controlador/ControladorComision.php");
require_once("../../Controlador/ControladorBitacora.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");

$user = '';
session_start();
if (isset($_SESSION['usuario'])) {
    $user = $_SESSION['usuario'];
    if (isset($_POST['idComision'])) {
        $nuevaComision = new Comision();
        $nuevaComision->idComision = intval($_POST['idComision']);
        $nuevaComision->estadoComision = $_POST['estadoComision'];
        $nuevaComision->ModificadoPor = $user;
        date_default_timezone_set('America/Tegucigalpa');
        $nuevaComision->fechaModificacion = date("Y-m-d");
        ControladorComision::actualizarComision($nuevaComision);

        ControladorComision::editarEstadoComisionVendedor($nuevaComision);
        /* ========================= Evento Editar Comision. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s");
        $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionComision.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' modificó una comision ';
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    }
    // $data = [
    //     'user' => 'Respuesta'
    // ];
    // print json_encode($data, JSON_UNESCAPED_UNICODE);
}
/* else {
    header('Location: ../login/login.php');
} */