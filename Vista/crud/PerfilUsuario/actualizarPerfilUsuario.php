<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
 }
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once ("../../../Modelo/Pregunta.php");
   require_once ("../../../Modelo/Bitacora.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   require_once("../../../Controlador/ControladorPregunta.php");
   require_once("../../../Controlador/ControladorBitacora.php");

   if(isset($_POST['nombre']) && isset($_SESSION['usuario'])){
      $newBitacora = new Bitacora();
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s"); 
      $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('EditarCamposPerfilUsuario.php');
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['income'];
      $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingreso a pantalla de editar datos del usuario';
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/
     
      $updateData=new Usuario();
      $updateData->usuario=$_SESSION['usuario'];
      $updateData->nombre=$_POST['nombre'];
      $updateData->rtn=$_POST['rtn'];
      $updateData->telefono=$_POST['telefono'];
      $updateData->direccion=$_POST['direccion'];
      $updateData->correo=$_POST['email'];
      $updateData->modificadoPor=$_SESSION['usuario'];
      ControladorUsuario::editarPerfilUsuario($updateData);
    
      /* ========================= Evento Editar tipo servicio. ====================================*/
      $newBitacora = new Bitacora();
      $accion = ControladorBitacora::accion_Evento();
      $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('EDITARCAMPOSPERFILUSUARIO.PHP');
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Update'];
      $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó su perfil de usuario';
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/
     
   }
 
