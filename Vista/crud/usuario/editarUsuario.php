<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->idUsuario = $_POST['idUsuario'];//aquí va la variable de inicio de 
        $nuevoUsuario->usuario = $_POST['usuario'];
        $nuevoUsuario->nombre = $_POST['nombre'];
        $nuevoUsuario->correo = $_POST['correo'];
        $nuevoUsuario->idRol = $_POST['idRol'];
        $nuevoUsuario->idEstado = $_POST['idEstado'];
        $nuevoUsuario->modificadoPor = $_SESSION['usuario'];
        ControladorUsuario::editarUsuario($nuevoUsuario);
        /* ========================= Evento Editar Usuario. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el usuario '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }