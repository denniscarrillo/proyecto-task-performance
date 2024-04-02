<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Articulo.php");
require_once ("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorArticulo.php");
require_once ("../../../Controlador/ControladorBitacora.php");

$user = '';
$eliminar = '';
session_start();
if(isset($_SESSION['usuario'])){
    $codArticulo = $_POST['codArticulo'];
    $estadoEliminado = ControladorArticulo::eliminarArticulo($codArticulo);
    print json_encode($estadoEliminado, JSON_UNESCAPED_UNICODE); 
    /* ========================= Evento Eliminar articulo. ====================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONARTICULO.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    if($estadoEliminado){
        $eliminar = " eliminó ";
        $newBitacora->accion = $accion['Delete'];
    }else{
        $eliminar = " intentó eliminar ";
        $newBitacora->accion = $accion['tryDelete'];
    }
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el artículo #'.$codArticulo.' '.$_POST['articulo'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/   
}

