<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $cantPreguntas = ControladorUsuario::cantidadPreguntas();
    $preguntasUsuario = array();
    $pregunta1 = "pregunta";
    if(isset($_POST["submit"])){
        for($i=0; $i < $cantPreguntas; $i++){
            $pregunta2 = strval($i);
            $pregunta = $pregunta1. $pregunta2; //Concatenamos el name de los inputs
            $preguntasUsuario[$i] = $_POST[$pregunta]; 
        }
        session_start();
        $user = $_SESSION['usuario'];
        ControladorUsuario::almacenarPreguntas($user, $preguntasUsuario);
        header ('location: respuestasPreguntas.php');
    }
    