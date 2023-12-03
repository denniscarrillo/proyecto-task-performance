<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/RubroComercial.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRubroComercial.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoRubroComercial = new rubroComercial();
        $nuevoRubroComercial->rubro_Comercial= $_POST['rubroComercial'];
        $nuevoRubroComercial->descripcion = $_POST['descripcion'];
        $nuevoRubroComercial->CreadoPor = $user;
        ControladorRubroComercial::crearRubroComercial($nuevoRubroComercial);
        /* ========================= Evento Creacion nueva Razon Social. ======================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRazonSocial.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['Insert'];
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creo la nueva Razon Social '.'"'.$_POST['razonSocial'].' - '.$_POST['descripcion'].'"';
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);

        /* =======================================================================================*/
    }
?>