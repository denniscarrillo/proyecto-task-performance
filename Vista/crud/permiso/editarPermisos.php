<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Permiso.php");
require_once ("../../../Modelo/Usuario.php");
require_once ("../../../Modelo/Parametro.php");
require_once ("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorPermiso.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorParametro.php");
require_once("../../../Controlador/ControladorBitacora.php");

session_start();
if(isset($_POST['rol'])){
    $arrayIds = ControladorPermiso::obtenerIdRolObjeto($_POST['rol'], $_POST['objeto']);
    //Creamos nuestro objeto permisos y lo llenamos
    $permisos = new Permiso();
    $permisos->idRol =  $arrayIds['idRol'];
    $permisos->idObjeto = $arrayIds['idObjeto'];
    $permisos->permisoConsultar = $_POST['consultar'];
    $permisos->permisoInsercion = $_POST['insertar'];
    $permisos->permisoActualizacion = $_POST['actualizar'];
    $permisos->permisoEliminacion = $_POST['eliminar'];
    $permisos->permisoReporte = $_POST['reporte'];
    $permisos->Moficado_Por = $_SESSION['usuario'];
    //Ahora enviamos el objeto al metodo y actualizamos los permisos en la DB
    ControladorPermiso::actualizarPermisosRol($permisos);
    /* ========================= Evento Editar pregunta. ====================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONPERMISOS.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Update'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó el permisos #'.$arrayIds['idRol'].' para rol '.$_POST['rol'].' sobre el objeto '.$_POST['objeto'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}