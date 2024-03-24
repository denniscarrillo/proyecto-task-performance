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
        if($estadoEliminado){
            $eliminar = " eliminó ";
        }else{
            $eliminar = " intentó eliminar ";
        }
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONOBJETO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el objeto #'.$_POST['id_Objeto'].' '.$_POST['objeto'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
