<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    $mensaje = '';
    if (isset($_POST["submit"])){
        $usuario = 'EMARTINEZ';
        $respuesta = $_POST["Respuesta"];
        $idPregunta = $_POST["pregunta"];
        $cantRespuestasFallidas = ControladorUsuario::intentosFallidosRespuesta();
        $respuestaC = ControladorUsuario::obtenerRespuesta($idPregunta);
        for($cantRespuestas = 0; $cantRespuestas < $cantRespuestasFallidas; $cantRespuestas++){
            if($respuesta == $respuestaC){
                header('location: v_nuevaContrasenia.php');
                break;
            }else if($cantRespuestas >= $cantRespuestasFallidas){
                ControladorUsuario::bloquearUsuarioMetodoPregunta($usuario);
            }else{
                $mensaje = 'Respuesta no válida';
            }
        }
        // if($respuesta == $respuestaC){
        //     header('location: v_nuevaContrasenia.php');
        // } else {
        //     $mensaje = 'Respuesta no válida';
            
        // }
    }

