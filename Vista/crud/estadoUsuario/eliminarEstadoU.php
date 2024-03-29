<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/EstadoUsuario.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorEstadoUsuario.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
   
    $eliminar = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $estadoEliminado = ControladorEstadoUsuario::eliminarEstadoU($_POST['idEstadoU']);
        print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Eliminar estado usuario. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONESTADOUSUARIO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        if($estadoEliminado){
            $eliminar = " eliminó ";
            $newBitacora->accion = $accion['Delete'];
        }else{
            $eliminar = " intentó eliminar ";
            $newBitacora->accion = $accion['tryDelete'];
        }
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el estado usuario #'.$_POST['idEstadoU'].' '.$_POST['estado'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
    