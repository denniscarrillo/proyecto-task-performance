<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Solicitud.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorSolicitud.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    require_once ("../../../Modelo/Usuario.php");
    

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $editarSolicitud = new Solicitud();
        $editarSolicitud->idSolicitud = $_POST['idSolicitud'];
        $editarSolicitud->fechaEnvio = $_POST['fechaEnvio'];
        $editarSolicitud->descripcion = $_POST['descripcion'];
        $editarSolicitud->correo = $_POST['correo'];
        $editarSolicitud->ubicacion = $_POST['ubicacion'];
        $editarSolicitud->idEstadoSolicitud = $_POST['idEstadoSolicitud'];
        $editarSolicitud->idTipoServicio = $_POST['idTipoServicio'];
        $editarSolicitud->idCliente = $_POST['idCliente'];
        $editarSolicitud->idUsuario = $_POST['idUsuario'];
        ControladorSolicitud::editarSolicitud($editarSolicitud);
        /* ========================= Evento Editar. ======================
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionSolicitud.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó la solicitud '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
         =======================================================================================*/
    }

    