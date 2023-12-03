<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/RazonSocial.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRazonSocial.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    // $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $editarRazonSocial = new razonSocial();
        $editarRazonSocial->id_RazonSocial = $_POST['id_RazonSocial'];
        $editarRazonSocial->razon_Social = $_POST['razonSocial'];
        $editarRazonSocial->descripcion = $_POST['descripcion'];
        ControladorRazonSocial::editarRazonSocial($editarRazonSocial);
        /* ========================= Evento Creacion nueva Razon Social. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRazonSocial.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modifico la razon social '.'"'.$_POST['razonSocial'].' - '.$_POST['descripcion'].'"';
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);

        /* =======================================================================================*/
    }
?>