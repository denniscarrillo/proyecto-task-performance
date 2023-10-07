<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    
    $mensaje = '';
    $mensaje2 = '';
    $idPregunta = '';
    $usuario = '';
    session_start(); //Reanudamos la sesion
    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $respuestaContestada = ControladorUsuario::obtenerRespuesta($idPregunta, $usuario);
        $cantFallidasParametro = ControladorUsuario::intentosFallidosRespuesta();
        $cantFallidasRespuestas = ControladorUsuario::obtenerIntentosRespuestas($usuario);
        if (isset($_POST["submit"])){
            if($cantFallidasRespuestas < $cantFallidasParametro){
                $respuesta = $_POST["Respuesta"];
                $idPregunta = $_POST["pregunta"];
                if($respuesta == $respuestaContestada){
                    ControladorUsuario::reiniciarIntentosFallidosRespuesta($usuario);
                    header('location: v_nuevaContrasenia.php');
                }else {
                    ControladorUsuario::aumentarIntentosFallidosRespuesta($usuario, $cantFallidasRespuestas);
                    $mensaje = 'Respuesta no válida';
                }
            }else if($cantFallidasRespuestas == $cantFallidasParametro){
                ControladorUsuario::bloquearUsuarioMetodoPregunta($usuario);
                //bitacora aqui
                $mensaje = 'El usuario ha sido bloqueado';
                $mensaje2 = 'Haga clic en "Cancelar" para intentarlo de nuevo';
            }    
        }
    }
    
    

