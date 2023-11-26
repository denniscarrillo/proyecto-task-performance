<?php 
    session_start(); //Reanudamos session
    require_once("../../../db/Conexion.php");
    require_once("../../../Modelo/Tarea.php");
    require_once("../../../Modelo/Usuario.php");
    require_once("../../../Modelo/BitacoraTarea.php");
    require_once("../../../Controlador/ControladorTarea.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacoraTarea.php");

    if(isset($_SESSION['usuario']) && isset($_POST['datosCotizacion'])){
        $idCotizacion = ControladorTarea::nuevaCotizacion($_POST['datosCotizacion'], $_SESSION['usuario']);
        ControladorTarea::productosCotizacion($idCotizacion['id_Cotizacion'], $_POST['productos'], $_SESSION['usuario']);
        $idTarea = $_POST['datosCotizacion']['idTarea'];
        /* ====================== Evento, el usuario ha creado una nueva cotizacion. =====================*/
        $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
        $newBitacora = new BitacoraTarea();
        $newBitacora->idTarea = intval($idTarea);
        $newBitacora->descripcionEvento = 'Ha creado la Cotización # '.$idCotizacion['id_Cotizacion'];
        $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
        /* =======================================================================================*/
    }
