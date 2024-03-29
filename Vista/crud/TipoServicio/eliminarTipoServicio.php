<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/TipoServicio.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorTipoServicio.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
    $eliminar = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $estadoEliminado = ControladorTipoServicio::eliminarTipoServicio($_POST['idTipoServico']);
        print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Eliminar tipo servicio. ===============================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONTIPOSERVICIO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        if($estadoEliminado){
            $eliminar = " eliminó ";
            $newBitacora->accion = $accion['Delete'];
        }else{
            $eliminar = " intentó eliminar ";
            $newBitacora->accion = $accion['tryDelete'];
        }
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el tipo de servicio #'.$_POST['idTipoServico'].' '.$_POST['servicio'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
    

