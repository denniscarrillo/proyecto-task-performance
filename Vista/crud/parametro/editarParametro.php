<?php
    require_once ("../../../db/Conexion.php");
    // require_once ("../../../Modelo/Usuario.php");
    // require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Parametro.php");
    // require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorParametro.php");
    // require_once("../../../Controlador/ControladorBitacora.php");
    

    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
        $nuevoParametro = new Parametro();
        $nuevoParametro->idParametro = $_POST['idParametro'];
        $nuevoParametro->parametro = $_POST['parametro'];
        $nuevoParametro->valor = $_POST['valor'];
        ControladorParametro::editarParametroSistema($nuevoParametro);
        /* ========================= Evento Editar Usuario. ======================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['Update'];
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el usuario '.$_POST['usuario'];
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        // /* =======================================================================================*/
    // }