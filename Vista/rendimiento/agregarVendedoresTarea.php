<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $idTarea = intval($_POST['idTarea']);
    $vendedores = json_decode($_POST['vendedores'], true);
    //Guardamos los vendedores agregados a la tarea
    ControladorTarea::agregarVendores($idTarea, $vendedores);
    if($estado){
        $usuario = ControladorBitacoraTarea::obtenerUsuario(intval($vendedores[0]['idVendedor']));
        /* ====================== Evento, el usuario ha agregado vendedores a la tarea. =======================================================================*/
        $estado = ControladorBitacoraTarea::obtenerEstadoAvanceTarea($idTarea);
        $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
        $newBitacora = new BitacoraTarea();
        $newBitacora->idTarea = intval($idTarea);
        $newBitacora->descripcionEvento = 'Ha agregado al vendedor '.$usuario.' a la tarea # '.$idTarea.' en el estado '.$estado;
        $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
        /* ============================================================================================================================================*/
    }
}