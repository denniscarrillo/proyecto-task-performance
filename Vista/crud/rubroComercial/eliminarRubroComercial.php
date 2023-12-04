<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/RubroComercial.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRubroComercial.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $estadoEliminado = ControladorRubroComercial::eliminarRubroComercial(intval($_POST['id_RubroComercial']));
        print json_encode($estadoEliminado, JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Creacion nuevo porcentaje. ======================*/
        if($estadoEliminado){
            $newBitacora = new Bitacora();
            $accion = ControladorBitacora::accion_Evento();
            date_default_timezone_set('America/Tegucigalpa');
            $newBitacora->fecha = date("Y-m-d h:i:s"); 
            $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRubroComercial.php');
            $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
            $newBitacora->accion = $accion['Delete'];
            $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' elimino el Rubro Comercial '.'"'.$_POST['rubroComercial'];
            ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        }
        /* =======================================================================================*/
    }
?>