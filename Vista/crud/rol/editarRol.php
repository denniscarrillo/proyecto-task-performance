<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Rol.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRol.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevoRol = new Rol();
        $nuevoRol->id_Rol = $_POST['idRol'];//aquí va la variable de inicio de 
        $nuevoRol->descripcion = $_POST['descripcion'];
        $nuevoRol->ModificadoPor = $_SESSION['usuario'];
        ControladorRol::editarRolUsuario($nuevoRol);
        /* ========================= Evento Editar rol. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRol.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó la descripción del rol #'.$_POST['idRol'].' '.$_POST['rol'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }