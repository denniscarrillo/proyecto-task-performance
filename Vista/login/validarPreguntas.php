<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("validarDatosLogin.php");

    // session_start();
    // if(isset($_SESSION['usuario'])){
    //     $user = $_SESSION['usuario'];
    // }
    $cantPreguntas = ControladorUsuario::cantidadPreguntas();
    $preguntasUsuario = array();
    $pregunta1 = "pregunta";
    if(isset($_POST["submit"])){
        for($i=0; $i < $cantPreguntas; $i++){
            $pregunta2 = strval($i);
            $pregunta = $pregunta1. $pregunta2; //Concatenamos el name de los inputs
            $preguntasUsuario[$i] = $_POST[$pregunta]; 
        }
        ControladorUsuario::almacenarPreguntas($preguntasUsuario, $user);
    }
    // session_destroy();