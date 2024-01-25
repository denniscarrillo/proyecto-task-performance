<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Rol.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorRol.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");

$user = '';
session_start();
if (isset($_SESSION['usuario'])) {
    $rol = $_POST['idRol'];
    $estadoEliminado = ControladorRol::eliminarRol($rol);
    print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
    /* ========================= Evento Editar pregunta. ====================================*/
    // $newBitacora = new Bitacora();
    // $accion = ControladorBitacora::accion_Evento();
    // date_default_timezone_set('America/Tegucigalpa');
    // $newBitacora->fecha = date("Y-m-d h:i:s"); 
    // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONROL.PHP');
    // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    // $newBitacora->accion = $accion['Update'];
    // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó la pregunta '.$_POST['pregunta'];
    // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}
