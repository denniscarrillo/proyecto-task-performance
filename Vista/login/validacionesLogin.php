<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once ("../../Modelo/Bitacora.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("../../Controlador/ControladorBitacora.php");

    $mensaje = null;
    $usuario = false;
    $nuevoEstado = false;
    $estadoUsuario = null;
    $intentosMax = intval(ControladorUsuario::intentosLogin());
    if(isset($_POST["submit"])){
        $nombreUsuario = $_POST["userName"];
        $intentosFallidos = ControladorUsuario::intentosFallidos($_POST["userName"]);
        $estadoUsuario = ControladorUsuario::estadoUsuario($_POST["userName"]);
        $rolUsuario = ControladorUsuario::obRolUsuario($_POST["userName"]);
        if(empty($_POST["userName"]) or empty($_POST["userPassword"])){
            $mensaje = 'Debe llenar ambos campos';
        } else {
            if($estadoUsuario > 2 && $estadoUsuario < 5){
                switch($estadoUsuario){
                    case 3: {
                        $mensaje = 'Usuario inactivo';
                        break;
                    }
                    case 4: {
                        $mensaje = 'Usuario bloqueado';
                        break;
                    }
                    case 5: {
                        $mensaje = 'Usuario de vacaciones';
                        break;
                    };
                }
            } else {
                if($rolUsuario == 1){
                    $mensaje = 'Contacte con su administrador, no tiene rol asignado!';
                } else {
                    $existeUsuario = ControladorUsuario::login($_POST["userName"], $_POST["userPassword"]);
                    if($existeUsuario){
                        $estadoVencimiento = ControladorUsuario::estadoFechaVencimientoContrasenia($_POST["userName"]);
                        if($estadoVencimiento){
                            session_start();
                            $_SESSION['usuario'] = $nombreUsuario;
                            /* ========================= Capturar evento inicio sesión. =============================*/
                            $newBitacora = new Bitacora();
                            $accion = ControladorBitacora::accion_Evento();
                            date_default_timezone_set('America/Tegucigalpa');
                            $newBitacora->fecha = date("Y-m-d h:i:s"); 
                            $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('login.php');
                            $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
                            $newBitacora->accion = $accion['Login'];
                            $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingresó al sistema exitosamente';
                            ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
                            /* =======================================================================================*/
                            switch($estadoUsuario){
                                case 1: {
                                    if($intentosFallidos > 0){
                                        ControladorUsuario::resetearIntentos($_POST["userName"]);
                                    }
                                    header('location: configRespuestas.php');
                                 break; 
                                }   
                                case 2: {
                                    if($intentosFallidos > 0){
                                        ControladorUsuario::resetearIntentos($_POST["userName"]);
                                    }
                                    if($rolUsuario > 1){
                                        header('location: ../index.php');
                                    }
                                } 
                            }
                        }else{
                            $mensaje = 'Contraseña vencida';
                        }
                    } else {
                        if ($intentosFallidos === false){
                            $mensaje = 'Usuario no existe';
                        } else {
                            $incremento = ControladorUsuario::incrementarIntentos($_POST["userName"], $intentosFallidos);
                            $nuevoEstado = Usuario::bloquearUsuario($intentosMax, $incremento, $_POST["userName"]); 
                            if($nuevoEstado == true || $estadoUsuario == 4){
                                $mensaje = 'Usuario bloqueado';
                            } else {
                                $mensaje = 'Usuario y/o Contraseña invalidos';
                            }  
                        }
                    }
                }
            }
        }
    }