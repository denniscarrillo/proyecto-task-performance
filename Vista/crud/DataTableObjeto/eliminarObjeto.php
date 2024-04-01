<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorDataTableObjeto.php");
    require_once ("../../../Controlador/ControladorBitacora.php");

    $user = '';
    $eliminar = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $estadoEliminado = ControladorDataTableObjeto::eliminarObjeto($_POST['id_Objeto'], $_POST['objeto']);
        print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Eliminar pregunta. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONOBJETO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        if($estadoEliminado){
            $eliminar = " eliminó ";
            $newBitacora->accion = $accion['Delete'];
        }else{
            $eliminar = " intentó eliminar ";
            $newBitacora->accion = $accion['tryDelete'];
        }
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el objeto #'.$_POST['id_Objeto'].' '.$_POST['objeto'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
