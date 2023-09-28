<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    require_once '../../../Modelo/Parametro.php';
    require_once '../../../Controlador/ControladorParametro.php';
    require_once('enviarCorreoNuevoUsuario.php');
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->nombre = $_POST['nombre'];
        $nuevoUsuario->usuario = $_POST['usuario'];
        $nuevoUsuario->contrasenia = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);
        $nuevoUsuario->correo = $_POST['correo'];
        $nuevoUsuario->intentosFallidos = 0;
        $nuevoUsuario->idRol = $_POST['idRol'];
        $nuevoUsuario->idEstado = 1;
        $nuevoUsuario->preguntasContestadas = 0;
        date_default_timezone_set('America/Tegucigalpa');
        $nuevoUsuario->fechaCreacion = date("Y-m-d h:i:s");
        $nuevoUsuario->creadoPor = $user;
        $nuevoUsuario->fechaV = $_POST['fechaV'];        
        ControladorUsuario::registroUsuario($nuevoUsuario);
        ControladorUsuario::respaldarContrasenia($user, $_POST['usuario'], $nuevoUsuario->contrasenia, 2);
        enviarCorreoNuevoUsuario($nuevoUsuario->correo, $nuevoUsuario->usuario, $_POST['contrasenia']);
        /* ========================= Evento Creacion nuevo Usuario. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$user.' creó usuario '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
?>
