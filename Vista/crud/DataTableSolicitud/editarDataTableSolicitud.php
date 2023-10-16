<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableSolicitud.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorDataTableSolicitud.php");
    // require_once ("../../../Modelo/Bitacora.php");
    // require_once ("../../../Controlador/ControladorBitacora.php");
    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $EditarSolicitud = new DataTableSolicitud();
        $EditarSolicitud->idSolicitud = ($_POST['idSolicitud']);
        $EditarSolicitud->descripcion = ($_POST['descripcion']);
        $EditarSolicitud->telefono = ($_POST['telefono']);
        $EditarSolicitud->ubicacion = ($_POST['ubicacion']);
        $EditarSolicitud->EstadoAvance = ($_POST['EstadoAvance']);
        $EditarSolicitud->ModificadoPor = $user;
        ControladorDataTableSolicitud::editarDataTableSolicitud($EditarSolicitud);
        /* ========================= Evento Editar pregunta. ====================================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPregunta.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['Update'];
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó la pregunta '.$_POST['pregunta'];
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }

?>