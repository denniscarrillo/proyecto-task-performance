<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        if(isset($_POST['fechaDesde']) && isset($_POST['$fechaHasta'])){
            ControladorBitacora::depurarBitacoraSistema($_POST['fechaDesde'], $_POST['$fechaHasta']);
        }
        /* ========================= Evento Creacion pregunta. ==================================*/
    //    $newBitacora = new Bitacora();
    //    $accion = ControladorBitacora::accion_Evento();
    //    date_default_timezone_set('America/Tegucigalpa');
    //    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    //    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPregunta.php');
    //    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
    //    $newBitacora->accion = $accion['Insert'];
    //    $newBitacora->descripcion = 'El usuario '.$user.' creó la pregunta '.$_POST['pregunta'];
    //    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }

?>