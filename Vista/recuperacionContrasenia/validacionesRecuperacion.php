<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once "../../Modelo/Parametro.php";
    require_once "../../Controlador/ControladorParametro.php";
    require_once("enviarCorreo.php");

    $opcion = '';
    $existe = '';
    $mensaje = '';
    session_start(); //Iniciamos session
    if(isset($_POST['radioOption'])){
        $_SESSION['metodo'] = $_POST['radioOption'];
    }
    if(isset($_POST['submit'])){
        if(isset($_POST['usuario'])){
            $_SESSION['usuario'] = $_POST['usuario'];
        }
        if(isset($_SESSION['usuario']) && isset($_SESSION['metodo'])) {
            $usuario = $_SESSION['usuario'];
            $creadoPor = $_SESSION['usuario'];
            $metodoRec = $_SESSION['metodo'];
            $userExiste = ControladorUsuario::usuarioExiste($usuario);
            if($userExiste){
                //Si el método es recuperación por correo
                if($metodoRec == 'correo'){
                    $correo = ControladorUsuario::obCorreoUsuario($usuario);
                    if(!empty($correo)){
                        //Valida si en la tabla token ya existen 10 token, entonces busca el mas antiguo y lo elimina
                        ControladorUsuario::depurarTokenUsuario($usuario);
                        //Generar y Almacenar token en la base de datos correspondiente al usuario
                        $tokenListo = ControladorUsuario::almacenarToken($usuario, $creadoPor);
                        if($tokenListo > 0){
                            $horasVigencia = ControladorParametro::obtenerVigenciaToken();
                            $estadoEnvio = enviarCorreo($correo, $tokenListo, $horasVigencia);
                            if($estadoEnvio){
                                $_SESSION['tokenSend'] = 1;
                                header("location:v_SolicitarToken.php");
                            } else {
                                $mensaje = "Lo sentimos, al parecer no se ha podido enviar el correo";
                            }   
                        }
                    } else {
                        $mensaje = "Su usuario no tiene un correo configurado";
                        unset($_SESSION['usuario']);//Eliminamos la variable
                    }
                } else { //Si el método es recuperación por pregunta secreta
                    $cantPregContestadas = ControladorUsuario::cantPreguntasContestadas($usuario);
                    if($cantPregContestadas  > 0){
                        $cantFallidasRespuestas = ControladorUsuario::obtenerIntentosRespuestas($usuario);
                        $cantFallidasParametro = ControladorUsuario::intentosFallidosRespuesta();
                        if($cantFallidasRespuestas == $cantFallidasParametro){
                            ControladorUsuario::reiniciarIntentosFallidosRespuesta($usuario);
                        }
                        header("location: preguntasResponder.php");
                    } else {
                        $mensaje = "Su usuario no tiene preguntas configuradas";
                        unset($_SESSION['usuario']); //Eliminamos la variable
                    }
                } 
            } else {
                $mensaje = "El usuario ingresado no existe";
                unset($_SESSION['usuario']);//Eliminamos la variable
            }
        } else {
            $mensaje = "No existe un metodo";
        }
    }



    



