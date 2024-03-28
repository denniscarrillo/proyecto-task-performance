<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Parametro.php");
    require_once("../../../Controlador/ControladorParametro.php");

    session_start();
    if(isset($_SESSION['usuario'])){
        $parametro = $_POST['usuario'];
        $data = ControladorParametro::eliminarParametro($parametro);
        print json_encode($data, JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Eliminar Parametro. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPregunta.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['tryDelete'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' intentó eliminar la pregunta #'.$idPregunta.' '.$_POST['pregunta'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/

    }
        
