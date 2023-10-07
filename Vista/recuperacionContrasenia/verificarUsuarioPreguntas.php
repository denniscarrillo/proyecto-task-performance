<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once ("../../Modelo/Bitacora.php");
    require_once("../../Controlador/ControladorBitacora.php");
    
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
                /* ========================= Capturar evento intentos fallidos y bloquearlo =============================*/
                $newBitacora = new Bitacora();
                $accion = ControladorBitacora::accion_Evento();
                date_default_timezone_set('America/Tegucigalpa');
                $newBitacora->fecha = date("Y-m-d h:i:s"); 
                $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('preguntasResponder.php');
                $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
                $newBitacora->accion = $accion['BloqueoPreguntas'];
                $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ha sido bloqueado, acumuló '.$cantFallidasRespuestas.' intentos fallidos al recuperar su contraseña por preguntas';
                ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
                /* =======================================================================================================*/
                $mensaje = 'El usuario ha sido bloqueado';
                $mensaje2 = 'Haga clic en "Cancelar" para intentarlo de nuevo';
            }    
        }
    }
    
    

