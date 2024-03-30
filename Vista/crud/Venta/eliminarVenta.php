<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Venta.php");
require_once ("../../../Modelo/Usuario.php");
require_once ("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorVenta.php");
require_once ("../../../Controlador/ControladorUsuario.php");
require_once ("../../../Controlador/ControladorBitacora.php");

$eliminar = '';
session_start();
if(isset($_SESSION['usuario'])){
    $numFactura = $_POST['numFactura'];
    $estadoEliminado = ControladorVenta::eliminarVenta($numFactura);
    print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
    /* ========================= Evento Eliminar pregunta. ====================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONVENTA.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    if($estadoEliminado){
        $eliminar = " eliminó ";
        $newBitacora->accion = $accion['Delete'];
    }else{
        $eliminar = " intentó eliminar ";
        $newBitacora->accion = $accion['tryDelete'];
    }
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'la factura #'.$_POST['numFactura'].'para el RTN'.$_POST['rtnCliente'].' del cliente '.$_POST['nombreCliente'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}

