<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Rol.php");
/*     require_once ("../../../Modelo/Bitacora.php"); */
    require_once("../../../Controlador/ControladorRol.php");
/*     require_once("../../../Controlador/ControladorBitacora.php"); */
    $rol = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['id_Rol'])){
        $rol = $_SESSION['id_Rol'];
        $nuevoRol = new Rol();
        $nuevoRol->rol = $_POST['rol'];
        $nuevoRol->descripcion = $_POST['descripcion'];
        ControladorRol::registroRol($nuevoRol);
        /* ========================= Evento Creacion nuevo Usuario. ======================*/
/*         $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creo usuario '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora); */
        /* =======================================================================================*/
    }
?>