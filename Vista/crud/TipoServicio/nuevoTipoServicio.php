<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/TipoServicio.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorTipoServicio.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoTipoServicio = new TipoServicio();
        $nuevoTipoServicio->servicio_Tecnico = $_POST['servicio_Tecnico'];
        $nuevoTipoServicio->CreadoPor = $user;
        $nuevoTipoServicio->ModificadoPor = $user;
        ControladorTipoServicio::ingresarNuevoTipoServicio($nuevoTipoServicio);
         /* ========================= Evento Creacion tipo servicio. ==================================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionTipoServicio.php');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
       $newBitacora->accion = $accion['Insert'];
       $newBitacora->descripcion = 'El usuario '.$user.' creó el tipo servicio '.$_POST['servicio_Tecnico'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }