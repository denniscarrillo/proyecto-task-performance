<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    session_start();
    $user = $_SESSION['usuario'];
    $preguntas = ControladorUsuario::obtenerPreguntasUsuario($user);
    $idPreguntas = array();
    $cantPreguntas = count($preguntas);
    $respuestasUsuario = array();
    $respuesta1 = 'respuesta';
    if (isset($_POST['submit'])){
        for($i=0; $i < $cantPreguntas; $i++){
            $respuesta2 = strval($i);
            $respuesta = $respuesta1. $respuesta2; //Concatenamos el name de los inputs
            $respuestasUsuario[$i] = $_POST[$respuesta]; 
            $idPreguntas[$i] = $preguntas[$i]['id_pregunta'];
        }
        ControladorUsuario::guardarRespuestas($user, $idPreguntas, $respuestasUsuario);
        session_destroy();
        header ('location: login.php');
    }

    