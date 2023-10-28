<?php
session_start();
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorUsuario.php');

if(isset($_SESSION['usuario']) && isset($_POST['id_Tarea'])){
    ControladorTarea::agregarComentarioTarea(intval($_POST['id_Tarea']), $_POST['comentario'], $_SESSION['usuario']);
    /* ====================== Evento, el usuario creo un nuevo comentario. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
    $accion = ControladorTarea::acciones_Evento_Tareas();
    $newBitacora = new Tarea();
    $newBitacora->idTarea = intval($_POST['id_Tarea']);
    $newBitacora->accionEvento = $accion['nuevoComentario'];
    $newBitacora->descripcionEvento = 'El usuario ' . $_SESSION['usuario'] . ' agregó un nuevo comentario';
    ControladorTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
}