<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Usuario.php");
require_once ("../../../Modelo/Bitacora.php");
require_once ("../../../Controlador/ControladorBitacora.php");
require_once ("../../../Controlador/ControladorUsuario.php");

session_start();
$filtro = trim($_POST['filtro']);
if(isset($_SESSION['usuario']) && $filtro !== ''){
    /* ========================= Evento consultar por filtro. ====================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONOBJETO.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['filterQuery'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' consulto por el filtro "'.$filtro.'" en el mantenimiento objetos';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}
