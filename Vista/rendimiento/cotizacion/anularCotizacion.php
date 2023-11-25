<?php 
    session_start(); //Reanudamos session
    require_once("../../../db/Conexion.php");
    require_once("../../../Modelo/Tarea.php");
    require_once("../../../Modelo/Usuario.php");
    require_once("../../../Modelo/BitacoraTarea.php");
    require_once("../../../Controlador/ControladorTarea.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacoraTarea.php");

    if(isset($_SESSION['usuario'])){
        $estado = ControladorTarea::anularCotizacion(intval($_POST['idCotizacion']), $_SESSION['usuario']);
        print json_encode($estado, JSON_UNESCAPED_UNICODE);
        /* ====================== Evento, el usuario ha anulado una cotizacion. =====================*/
        $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
        $newBitacora = new BitacoraTarea();
        $newBitacora->idTarea = intval($_POST['idTarea']);
        $newBitacora->descripcionEvento = 'Ha anulado la Cotización # '.$_POST['idCotizacion'];
        $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
        /* =======================================================================================*/
    }