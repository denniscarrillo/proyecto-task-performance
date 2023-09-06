<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
require_once("../../Modelo/Bitacora.php");
require_once("../../Controlador/ControladorBitacora.php");

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  /* ========================= Capturar evento Mis Tareas. =============================*/
  $newBitacora = new Bitacora();
  $accion = ControladorBitacora::accion_Evento();
  date_default_timezone_set('America/Tegucigalpa');
  $newBitacora->fecha = date("Y-m-d h:i:s");
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('v_tarea.php');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingreso kanban de tarea';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  /* =======================================================================================*/
}else{
  header('location: ../login/login.php');
}

