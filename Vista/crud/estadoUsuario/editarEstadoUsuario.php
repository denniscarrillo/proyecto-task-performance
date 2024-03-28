<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Modelo/EstadoUsuario.php");
    require_once("../../../Controlador/ControladorEstadoUsuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorMetricas.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $editarEstado = new EstadoUsuario();
        $editarEstado->idEstado = $_POST['idEstadoU'];
        $editarEstado->descripcion = $_POST['descripcion'];
        $editarEstado->modificadoPor = $_SESSION['usuario'];
        ControladorEstadoUsuario::editarEstadoU($editarEstado);
        /* ========================= Evento Editar Usuario. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONESTADOUSUARIO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó la descripción del estado usuario #'.$_POST['idEstadoU'].' '.$_POST['descripcion'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }