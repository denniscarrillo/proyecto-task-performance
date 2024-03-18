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
            $estadoUsuario = intval(ControladorUsuario::estadoUsuario($usuario));
            $descripcionEstado = ControladorUsuario::obtenerDescripcionEstadoUsuario($estadoUsuario);
            if($userExiste){
                if($estadoUsuario == 2 || $estadoUsuario == 4){
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
                            ControladorUsuario::reiniciarIntentosFallidosRespuesta($usuario);
                          
                            // $idPregunta = obtenerIdPreguntaUsuario($usuario); // Reemplaza esto con la lógica real para obtener el ID de la pregunta

                            // // Validar si la pregunta está activa antes de redirigir
                            // if (ControladorPregunta::verificarPreguntaActiva($idPregunta)) {
                            //     header("location: preguntasResponder.php");
                            // } else {
                            //     $mensaje = "La pregunta está inactiva. Selecciona otra pregunta activa.";
                            // }

                        } else {
                            $mensaje = "Su usuario no tiene preguntas configuradas";
                            unset($_SESSION['usuario']); //Eliminamos la variable
                        }
                    } 
                }else{
                    switch($estadoUsuario){
                        case 1:{
                            $mensaje = "El estado del usuario es nuevo, no puede continuar";
                            break;
                        }
                        case 3:{
                            $mensaje = "Su usuario está inactivo, no puede continuar";
                            break;
                        }
                        case 5:{
                            $mensaje = "Usuario está suspendido por vacaciones";
                            break;
                        }
                        default:{
                            $mensaje = "Estado de usuario ".$descripcionEstado." sin acceso";
                            break;
                        }
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



    