<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Permiso.php");
require_once("../../../Controlador/ControladorPermiso.php");

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
}