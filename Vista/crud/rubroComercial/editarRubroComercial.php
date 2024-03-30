<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/RubroComercial.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRubroComercial.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    // $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
       $user = $_SESSION['usuario'];
       $editarRubroComercial = new rubroComercial();
       $editarRubroComercial->id_RubroComercial = $_POST['id_RubroComercial'];
       $editarRubroComercial->rubro_Comercial = $_POST['rubroComercial'];
       $editarRubroComercial->descripcion = $_POST['descripcion'];
        ControladorRubroComercial::editarRubroComercial($editarRubroComercial);
        /* ========================= Evento Creacion nueva Razon Social. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRubroComercial.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modifico la razon social '.'"'.$_POST['rubroComercial'].' - '.$_POST['descripcion'].'"';
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);

        /* =======================================================================================*/
    }
?>