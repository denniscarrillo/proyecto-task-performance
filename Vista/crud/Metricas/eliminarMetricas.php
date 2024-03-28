<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorMetricas.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorBitacora.php");

    $eliminar = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $metrica= $_POST['id_Metrica'];
        $estadoEliminado = ControladorMetricas::eliminarMetrica($metrica);
        print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Eliminar tipo servicio. ===============================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONMETRICAS.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        if($estadoEliminado){
            $eliminar = " eliminó ";
            $newBitacora->accion = $accion['Delete'];
        }else{
            $eliminar = " intentó eliminar ";
            $newBitacora->accion = $accion['tryDelete'];
        }
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'la métrica #'.$_POST['id_Metrica'].' '.$_POST['metrica'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
        