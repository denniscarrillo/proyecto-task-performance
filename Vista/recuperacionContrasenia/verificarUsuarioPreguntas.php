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
    $mensaje = '';
    $idPregunta = '';
    $usuario = '';
    session_start(); //Reanudamos la sesion
    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $respuestaContestada = ControladorUsuario::obtenerRespuesta($idPregunta);
        $cantFallidasParametro = ControladorUsuario::intentosFallidosRespuesta();
        $cantFallidasRespuestas = ControladorUsuario::obtenerintentosRespuestas($usuario);
        if (isset($_POST["submit"])){
            if($cantFallidasRespuestas < $cantFallidasParametro){
                $respuesta = $_POST["Respuesta"];
                $idPregunta = $_POST["pregunta"];
                if($respuesta == $respuestaContestada ){
                    ControladorUsuario::reiniciarIntentosFallidosRespuesta($usuario);
                    header('location: v_nuevaContrasenia.php');
                }else {
                    ControladorUsuario::aumentarIntentosFallidosRespuesta($usuario, $intentosFallidos);
                    $mensaje = 'Respuesta no válida';
                }
            }else if($cantFallidasRespuestas = $cantFallidasParametro){
                ControladorUsuario::bloquearUsuarioMetodoPregunta($usuario);
                $mensaje = 'El usuario ha sido bloqueado';
            }    
        }
    }
    
    

