<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $user = '';
    session_start();
    if (isset($_SESSION['usuario'])) {
        $user = $_SESSION['usuario'];
    }
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
        } 
    }

    