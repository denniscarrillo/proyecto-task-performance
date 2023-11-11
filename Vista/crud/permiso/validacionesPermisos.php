<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Permiso.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorPermiso.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])){
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionPermisos.php');
  (!($_SESSION['usuario'] == 'SUPERADMIN'))
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
    $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ==================== Evento intento de ingreso sin permiso a mantenimiento permiso. ==========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionPermisos.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a mantenimiento permiso';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  }else{
    if(isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])){
      /* ==================== Evento salir. ================================================*/
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
    /* ====================== Evento ingreso a mantenimiento permiso. ========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionPermisos.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a mantenimiento permiso';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionPermisos.php';
    $_SESSION['descripcionObjeto'] = 'mantenimiento permiso';
    /* =======================================================================================*/
  }
} else {
  header('location: ../../login/login.php');
  die();
}

function imprimirPermisos($permisos){
    //Se recorre el array de permisos que llega desde la base de datos
  foreach($permisos as $permiso){
    //Esto se hace para reflejar los permisos en los checkbox segun la base de datos
    $permisoConsultar = ($permiso['consultar'] == 'Y') ? "checked" : "";
    $permisoInsertar = ($permiso['insertar'] == 'Y') ? "checked" : "";
    $permisoActualizar = ($permiso['actualizar'] == 'Y') ? "checked" : "";
    $permisoEliminar = ($permiso['eliminar'] == 'Y') ? "checked" : "";

    //Se imprimen los permisos con su validaciones ya hechas
    echo '<tr class="tr-permisos">'.
      '<td class="td-permisos">'.$permiso['rolUsuario'].'</td>'.
      '<td class="td-permisos">'.$permiso['objetoSistema'].'</td>'.
      '<td class="td-permisos"><input type="checkbox" class="check-permisos" '.$permisoConsultar.'></td>'.
      '<td class="td-permisos"><input type="checkbox" class="check-permisos" '.$permisoInsertar.'></td>'.
      '<td class="td-permisos"><input type="checkbox" class="check-permisos" '.$permisoActualizar.'></td>'.
      '<td class="td-permisos"><input type="checkbox" class="check-permisos" '.$permisoEliminar.'></td>'.
      '<td class="td-permisos"><i class="fa-solid fa-circle-check btn_confirm"></i></td>'.
      '</tr>';
    }
}