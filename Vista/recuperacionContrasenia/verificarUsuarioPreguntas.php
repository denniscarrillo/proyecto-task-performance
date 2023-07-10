<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    $mensaje = '';
    if (isset($_POST["submit"])){
        $respuesta = $_POST["Respuesta"];
        $idPregunta = $_POST["pregunta"];
        $respuestaC = ControladorUsuario::obtenerRespuesta($idPregunta);
        if($respuesta == $respuestaC){
            header('location: v_nuevaContrasenia.php');
        } else {
            $mensaje = 'Respuesta no válida';
        }
    }

