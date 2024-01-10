<?php
session_start();
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');
require_once('../../Controlador/ControladorUsuario.php');

if(isset($_SESSION['usuario']) && isset($_POST['id_Tarea'])){
    $idComentario = ControladorBitacoraTarea::agregarComentarioTarea(intval($_POST['id_Tarea']), $_POST['comentario'], $_SESSION['usuario']);
    /* ====================== Evento, el usuario creo un nuevo comentario. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
    $newBitacora = new BitacoraTarea();
    $newBitacora->idTarea = intval($_POST['id_Tarea']);
    $newBitacora->descripcionEvento = 'El usuario agregó el nuevo comentario';
    $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
    ControladorBitacoraTarea::guardarBitacoraComentario($idBitacora, $idComentario);
}