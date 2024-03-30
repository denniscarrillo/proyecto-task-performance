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
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONUSUARIO.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['filterQuery'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' consultó por el filtro "'.$filtro.'" en el mantenimiento usuarios';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}