<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/TipoServicio.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorTipoServicio.php");

    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
        $nuevoTipoServicio = new TipoServicio();
        $nuevoTipoServicio->id_TipoServicio = $_POST['id_TipoServicio'];//aquí va la variable de inicio de 
        $nuevoTipoServicio->servicio_Tecnico = $_POST['servicio_Tecnico'];
        $nuevoTipoServicio->ModificadoPor = 'SUPERADMIN';
        ControladorTipoServicio::editarNuevoTipoServicio($nuevoTipoServicio);
        /* ========================= Evento Editar Usuario. ======================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['Update'];
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el usuario '.$_POST['usuario'];
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    // }