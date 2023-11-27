<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');

session_start();
if(isset($_SESSION['usuario'])){
    $estadoUpdate = ControladorTarea::finalizarTarea(intval($_POST['idTarea']));
    print json_encode($estadoUpdate, JSON_UNESCAPED_UNICODE);
    if($estadoUpdate){
        /* ====================== Evento, el SUPERADMIN ha finalizado la tarea. =====================*/
        $estado = ControladorBitacoraTarea::obtenerEstadoAvanceTarea($_POST['idTarea']);
        $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
        $newBitacora = new BitacoraTarea();
        $newBitacora->idTarea = intval($_POST['idTarea']);
        $newBitacora->descripcionEvento = 'Ha finalizado la tarea #'.$_POST['idTarea'].' en el estado '.$estado;
        $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
        /* =======================================================================================*/
    }
}