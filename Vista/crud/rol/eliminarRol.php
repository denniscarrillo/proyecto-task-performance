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
    $idRol = $_POST['idRol'];
    $rol = $_POST['rol'];
    $estadoEliminado = ControladorRol::eliminarRol($idRol);
    print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
    /* ========================= Evento Eliminar pregunta. ====================================*/
    if($estadoEliminado){
        $eliminar = " eliminó ";
    }else{
        $eliminar = " intentó eliminar ";
    }
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPregunta.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Update'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el rol #'.$idRol.' '.$rol;
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}
