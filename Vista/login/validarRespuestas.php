<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once ("../../Modelo/Bitacora.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("../../Controlador/ControladorBitacora.php");

    $user = '';
    session_start();
    if (isset($_SESSION['usuario'])) {
        /* ========================= Evento Configurar respuestas. ======================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('configRespuestas.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['income'];
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingreso a pantalla configuración respuestas';
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
        $user = $_SESSION['usuario'];
        $preguntas = ControladorUsuario::obtenerPreguntasUsuario();
        $cantPreguntasParametro = ControladorUsuario::cantidadPreguntas();
        $preguntasContestadasUsuario =  ControladorUsuario::cantPreguntasContestadas($user);
        $respuestasUsuario = array();
        if (isset($_POST['submit'])){
            if($preguntasContestadasUsuario < $cantPreguntasParametro){
                $idPregunta = $_POST['id_pregunta'];
                $respuestaUsuario = $_POST['respuesta']; 
                ControladorUsuario::guardarRespuestas($user, $idPregunta, $respuestaUsuario);
                ControladorUsuario::incrementarPregContestadas($user, $preguntasContestadasUsuario);
                $contestadas = $preguntasContestadasUsuario + 1;
                if($contestadas == $cantPreguntasParametro){
                    //Cambiar estado del usuario nuevo a Activo
                    ControladorUsuario::cambiarEstado($user);
                    $origen = ControladorUsuario::origenNuevoUsuario($user);
                    if($origen){
                        header ('location: login.php');
                        session_destroy();
                    } else {
                        header ('location: ../recuperacionContrasenia/v_nuevaContrasenia.php');
                    }
                }
                /* ========================= Evento Responder pregunta. ======================*/
                $newBitacora = new Bitacora();
                $accion = ControladorBitacora::accion_Evento();
                date_default_timezone_set('America/Tegucigalpa');
                $newBitacora->fecha = date("Y-m-d h:i:s"); 
                $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('configRespuestas.php');
                $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
                $newBitacora->accion = $accion['Insert'];
                $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' configuro la pregunta'.$_POST['id_pregunta'];
                ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
                /* =======================================================================================*/
            } 
        }
    }
    

    