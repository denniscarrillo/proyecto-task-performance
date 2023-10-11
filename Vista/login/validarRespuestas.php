<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once ("../../Modelo/Bitacora.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("../../Controlador/ControladorBitacora.php");

    $user = '';
    $mensaje = '';
    $p_guardada = 0;
    $preguntas = '';
    session_start();
    if (isset($_SESSION['usuario'])) {
        $user = $_SESSION['usuario'];
        $preguntas = ControladorUsuario::obtenerPreguntasUsuario();
        $cantPreguntasParametro = ControladorUsuario::cantidadPreguntas(); //Cantidad de preguntas a contestar parámetro
        if (isset($_POST['submit'])){
            $preguntasContestadasUsuario = ControladorUsuario::cantPreguntasContestadas($user);
            $respuestasUsuario = array();
            if($preguntasContestadasUsuario < $cantPreguntasParametro){
                $idPregunta = $_POST['id_pregunta'];
                $respuestaUsuario = $_POST['respuesta']; 
                $existePregunta = ControladorUsuario::validarPreguntasUsuario($idPregunta, $user);
                if(!$existePregunta){
                    ControladorUsuario::guardarRespuestas($user, $idPregunta, $respuestaUsuario);
                    $p_guardada = 1;
                    ControladorUsuario::incrementarPregContestadas($user, $preguntasContestadasUsuario);
                    $contestadas = $preguntasContestadasUsuario + 1;
                    if($contestadas == $cantPreguntasParametro){
                        //Cambiar estado del usuario nuevo a Activo
                        ControladorUsuario::cambiarEstado($user);
                        //Esto para saber desde donde fue creado el usuario. Si es desde Gestion Usuario se le pedira cambiar contraseña
                        $origen = ControladorUsuario::origenNuevoUsuario($user);
                        if($origen){
                            header ('location: login.php');
                            session_destroy();
                        } else {
                            header ('location: ../recuperacionContrasenia/v_nuevaContrasenia.php');
                        }
                    }
                } else {
                    $mensaje = "Por favor, elije otra pregunta, esta ya ha sido configurada";
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
    

    