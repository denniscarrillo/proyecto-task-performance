<?php
require_once '../../db/Conexion.php';
require_once '../../Modelo/Comision.php';
require_once '../../Controlador/ControladorComision.php';
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once("../../Modelo/Bitacora.php");
require_once("../../Controlador/ControladorBitacora.php");

$porcentajes = ControladorComision::traerPorcentajesComision();

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  if(isset($_SESSION['objetoAnterior'])){
    /* ====================== Evento ingreso a mantenimiento de usuario. =====================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Exit'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de '.$_SESSION['descripcionObjeto'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  /* =======================================================================================*/
  }
  /* ========================= Capturar evento Mis Tareas. =============================*/
  $accion = ControladorBitacora::accion_Evento();
  date_default_timezone_set('America/Tegucigalpa');
  $newBitacora->fecha = date("Y-m-d h:i:s");
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('v_comision.php');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a comisión';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  $_SESSION['objetoAnterior'] = 'v_comision.php';
  $_SESSION['descripcionObjeto'] = 'comisión';
  /* =======================================================================================*/
}else{
  header('location: ../login/login.php');
  die();
}