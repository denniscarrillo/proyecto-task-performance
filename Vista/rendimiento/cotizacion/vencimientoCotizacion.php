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
        $idCotizacion = $_POST['idCotizacion'];
        $estado = ControladorTarea::calcularVencimientoCotizacion($idCotizacion);
        $Tarea = ControladorBitacoraTarea::obtenerTareaCotizacion($idCotizacion);
        if($estado && $Tarea['estado'] != 'Vencida'){
            ControladorTarea::vencimientoEstadoCotizacion($idCotizacion);
            /* ====================== Evento, la cotizacion ha sido vencida. =====================*/
                $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
                $newBitacora = new BitacoraTarea();
                $newBitacora->idTarea = intval($Tarea['id']);
                $newBitacora->descripcionEvento = 'Ha vencido la vigencia de la cotización # '.$_POST['idCotizacion'];
                $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
            /* ===========================================================================================*/
        }
    }