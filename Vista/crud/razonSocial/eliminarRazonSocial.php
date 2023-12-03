<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Porcentajes.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorPorcentajes.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $eliminarRazonSocial = new razonSocial();
        $eliminarRazonSocial->id_RazonSocial = $_POST['id_RazonSocial'];
        ControladorRazonSocial::eliminarRazonSocial($eliminarRazonSocial);
        /* ========================= Evento Creacion nuevo porcentaje. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRazonSocial.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Delete'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' elimino la Razon Social '.'"'.$_POST['razonSocial'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);

        /* =======================================================================================*/
    }
?>