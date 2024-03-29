<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Pregunta.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorPregunta.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $insertarPregunta = new Pregunta();
        $insertarPregunta->idPregunta = ($_POST['idPregunta']);
        $insertarPregunta->pregunta = ($_POST['pregunta']);
        $insertarPregunta->estado = ($_POST['estado']);
        $insertarPregunta->ModificadoPor = $user;
        ControladorPregunta::actualizarPregunta($insertarPregunta);
        /* ========================= Evento Editar pregunta. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPregunta.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó la pregunta #'.$_POST['idPregunta'].' '.$_POST['pregunta'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }