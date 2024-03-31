<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/RazonSocial.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRazonSocial.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $RazonSocial= $_POST['id_RazonSocial'];
        $estadoEliminado = ControladorRazonSocial::eliminarRazonSocial( $RazonSocial);
        print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Creacion nueva Razon Social. ======================*/
        if($estadoEliminado){
            $newBitacora = new Bitacora();
            $accion = ControladorBitacora::accion_Evento();
            $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionRazonSocial.php');
            $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
            if($estadoEliminado){
                $eliminar = " eliminó ";
                $newBitacora->accion = $accion['Delete'];
            }else{
                $eliminar = " intentó eliminar ";
                $newBitacora->accion = $accion['tryDelete'];
            }
            $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' elimino la Razon Social #'.$_POST['id_RazonSocial'].$_POST['razonSocial'];
            ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        }
        /* =======================================================================================*/
    }