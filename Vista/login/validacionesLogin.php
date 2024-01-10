<?php
session_start();
require_once("../../db/Conexion.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/Bitacora.php");
require_once("../../Controlador/ControladorUsuario.php");
require_once("../../Controlador/ControladorBitacora.php");

$registro = 0;
if (isset($_SESSION['registro'])) { //Cuando venimos de registro capturamos el valor para saberlo
    $registro = $_SESSION['registro'];
    /*
        Ahora eliminamos esa variable global para que el Toast que se muestra con javascript 
        no se vuelva a mostrar cuando la pagina se refresque por cualquier motivo
    */
    session_unset();
    session_destroy();
}
$mensaje = null;
$usuario = false;
$nuevoEstado = false;
$estadoUsuario = null;
if (isset($_POST["submit"])) {
    $nombreUsuario = $_POST["userName"];
    $intentosMax = ControladorUsuario::intentosLogin();
    $intentosFallidos = ControladorUsuario::intentosFallidos($_POST["userName"]);
    $estadoUsuario = ControladorUsuario::estadoUsuario($_POST["userName"]);
    $rolUsuario = ControladorUsuario::obRolUsuario($_POST["userName"]);
    if (empty($_POST["userName"]) or empty($_POST["userPassword"])) {
        $mensaje = 'Debe llenar ambos campos';
    } else {
        if ($estadoUsuario > 2 && $estadoUsuario <= 5) {
            switch ($estadoUsuario) {
                case 3: {
                        $mensaje = 'Su usuario se encuentra inactivo';
                        break;
                    }
                case 4: {
                        $mensaje = 'Su usuario se encuentra bloqueado';
                        break;
                    }
                case 5: {
                        $mensaje = 'Usted está de vacaciones';
                        break;
                    }
            }
        } else {
            if ($rolUsuario == 1 && $_POST["userName"]!= 'SUPERADMIN') {
                $mensaje = 'Contacte con su administrador, aún no tiene rol asignado';
            } else {
                $existeUsuario = ControladorUsuario::login($_POST["userName"], $_POST["userPassword"]);
                if ($existeUsuario) {
                    $estadoVencimiento = ControladorUsuario::estadoFechaVencimientoContrasenia($_POST["userName"]);
                    if ($estadoVencimiento) {
                        $_SESSION['usuario'] = $nombreUsuario;
                        /* ========================= Capturar evento inicio sesión. =============================*/
                        $newBitacora = new Bitacora();
                        $accion = ControladorBitacora::accion_Evento();
                        date_default_timezone_set('America/Tegucigalpa');
                        $newBitacora->fecha = date("Y-m-d h:i:s");
                        $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('login.php');
                        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
                        $newBitacora->accion = $accion['Login'];
                        $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó al sistema exitosamente';
                        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
                        /* =======================================================================================*/
                        $cantPreguntasContestadas = ControladorUsuario::cantPreguntasContestadas($_SESSION['usuario']);
                        $cantPreguntasParametro = ControladorUsuario::cantidadPreguntas();
                        switch ($estadoUsuario) {
                            case 1: {
                                    if ($intentosFallidos > 0) {
                                        ControladorUsuario::resetearIntentos($_POST["userName"]);
                                    }
                                    if($cantPreguntasContestadas != $cantPreguntasParametro){
                                        header('location: configRespuestas.php');
                                    }else{
                                        //Cambia el estado del usuario de nuevo a Activo
                                        ControladorUsuario::desbloquearUsuario($_SESSION['usuario']);
                                        header('location: ../index.php');
                                    }
                                    break;
                                }
                            case 2: {
                                    if ($intentosFallidos > 0) {
                                        ControladorUsuario::resetearIntentos($_POST["userName"]);
                                    }
                                    if ($rolUsuario > 1 && ($cantPreguntasContestadas == $cantPreguntasParametro) 
                                                        //Si el usuario es SUPERADMIN no necesitara de ningun ROL para poder interactuar con acceso a todos los modulos
                                                        || ($_POST["userName"] == 'SUPERADMIN') && ($cantPreguntasContestadas == $cantPreguntasParametro)) {
                                        header('location: ../index.php');
                                    }else{
                                        header('location: configRespuestas.php');
                                    }
                                    break;
                                }
                        }
                    } else {
                        $mensaje = 'Su contraseña ha vencido, por favor restablecerla';
                    }
                } else {
                    if ($intentosFallidos === false) {
                        //Observacion, este escenario tambien se debe incluir en el conteo de INTENTO PERMITIDOS para bloquearlo cuando exceda
                        $mensaje = 'El usuario ingresado no existe'; //Este mensaje solo se debe mostrar mientras este en DESARROLLO
                        // $mensaje = 'Usuario y/o Contraseña incorrectos';
                    } else {
                        $incremento = ControladorUsuario::incrementarIntentos($_POST["userName"], $intentosFallidos);
                        $nuevoEstado = Usuario::bloquearUsuario($intentosMax, $incremento, $_POST["userName"]);
                        if (($intentosFallidos + 1) == $intentosMax) {
                            $mensaje = 'Ha alcanzado el límite de intentos fallidos, no debe equivocarse de nuevo';
                        } else if ($nuevoEstado == true || $estadoUsuario == 4) {
                            $mensaje = 'Su usuario ha sido bloqueado por exceder el número de intentos fallidos';
                        } else {
                            $mensaje = 'Usuario y/o Contraseña incorrectos';
                        }
                    }
                }
            }
        }
    }
}