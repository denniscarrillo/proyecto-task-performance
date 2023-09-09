<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/TipoServicio.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorTipoServicio.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevoTipoServicio = new TipoServicio();
        $nuevoTipoServicio->id_TipoServicio = $_POST['id_TipoServicio'];//aquí va la variable de inicio de 
        $nuevoTipoServicio->servicio_Tecnico = $_POST['servicio_Tecnico'];
        $nuevoTipoServicio->ModificadoPor = $_SESSION['usuario'];
        ControladorTipoServicio::editarNuevoTipoServicio($nuevoTipoServicio);
        /* ========================= Evento Editar tipo servicio. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionTipoServicio.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el tipo de servicio '.$_POST['servicio_Tecnico'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }