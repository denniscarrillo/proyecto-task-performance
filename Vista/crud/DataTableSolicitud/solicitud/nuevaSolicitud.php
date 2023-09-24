<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Solicitud.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorSolicitud.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevaSolicitud = new Solicitud();
        $nuevaSolicitud->idUsuario = $_POST['idUsuario'];
        $nuevaSolicitud->idEstadoSolicitud = 1;
        $nuevaSolicitud->idTipoServicio = $_POST['idTipoServicio'];
        $nuevaSolicitud->idCliente = $_POST['idCliente'];
        $nuevaSolicitud->fechaEnvio = $_POST['fechaEnvio'];
        $nuevaSolicitud->titulo = $_POST['titulo'];
        $nuevaSolicitud->correo = $_POST['correo'];
        $nuevaSolicitud->descripcion = $_POST['descripcion'];
        $nuevaSolicitud->ubicacion = $_POST['ubicacion'];
        ControladorSolicitud::crearSolicitud($nuevaSolicitud);
        /* ========================= Evento Creacion nueva solicitud. ======================
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionSolicitud.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creó solicitud '.$_POST['tituloMensaje'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        =======================================================================================*/
    }
?>
