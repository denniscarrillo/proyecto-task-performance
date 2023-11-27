<?php
session_start(); //Reanudamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/BitacoraTarea.php");
require_once('../../Controlador/ControladorTarea.php');
require_once("../../Controlador/ControladorUsuario.php");
require_once("../../Controlador/ControladorBitacoraTarea.php");

if(isset($_SESSION['usuario']) && $_POST['idTarea']){ //Validamos si existe una session y el usuario
  ControladorTarea::actualizarEstadoTarea(intval($_POST['idTarea']), intval($_POST['nuevoEstado']), $_SESSION['usuario']);
  /* ====================== Evento, el usuario ha cambiado la tarea de estado  =====================*/
  $estado = ControladorBitacoraTarea::obtenerEstadoAvanceTarea($_POST['idTarea']);
  $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
  $newBitacora = new BitacoraTarea();
  $newBitacora->idTarea = intval($_POST['idTarea']);
  $newBitacora->descripcionEvento = 'Ha cambiado el estado de la tarea a '.$estado;
  $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
/* ===========================================================================================*/
}