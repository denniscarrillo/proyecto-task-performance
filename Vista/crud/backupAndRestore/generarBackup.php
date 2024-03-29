<?php
session_start();
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/BackupRestore.php");
require_once("../../../Controlador/ControladorBackupRestore.php");

if(isset($_SESSION['usuario'])){
    date_default_timezone_set('America/Tegucigalpa');
    $fechaBackup = date("Y-m-d h:i:s");
    $fechaBackup = str_replace(" ", "_", $fechaBackup);
    $fechaBackup = str_replace(":", "_", $fechaBackup);

    $rutaArchivoServidor = dirname(__FILE__).'\backups\RENDIMIENTO_TAREAS_'.$fechaBackup.'.bak';
    $urlRutaArchivoServidor = '\backups\RENDIMIENTO_TAREAS_'.$fechaBackup.'.bak';
    
    $estadoBackup = ControladorBackupRestore::generarBackup($rutaArchivoServidor);
    // ControladorBackupRestore::insertarHistorialBackup($urlRutaArchivoServidor, $_SESSION['usuario']);

    var_dump($estadoBackup);
    // print json_encode($estadoBackup);
}


