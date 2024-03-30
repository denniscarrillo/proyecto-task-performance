<?php
session_start();
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/BackupRestore.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorBackupRestore.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once("../../../Controlador/ControladorUsuario.php");

if(isset($_SESSION['usuario'])){
    date_default_timezone_set('America/Tegucigalpa');
    $fechaBackup = date("Y-m-d h:i:s");
    $fechaBackup = str_replace(" ", "_TIME-", $fechaBackup);
    $fechaBackup = str_replace(":", "-", $fechaBackup);
    $estadoRestore = null;
    $rutaArchivoServidor = dirname(__FILE__).'\backups\RENDIMIENTO_TAREAS_'.$fechaBackup.'.bak';
    $urlRutaArchivoServidor = '\backups\RENDIMIENTO_TAREAS_'.$fechaBackup.'.bak';
    $estadoBackup = ControladorBackupRestore::generarBackup($rutaArchivoServidor);
    
    if ($estadoBackup) {
        ControladorBackupRestore::insertarHistorialBackup($urlRutaArchivoServidor, $_SESSION['usuario']);
        /* ======================================= Evento generar Backup. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONBACKUPRESTORE.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['backup'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' generó el backup "RENDIMIENTO_TAREAS_'.$fechaBackup.'.bak"';
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
        $urlRestore = dirname(__FILE__).$_POST['historial-backups'];
        $_SESSION['estadoRestore'] = 1;
        $_SESSION['urlArchivoRestore'] = $urlRestore;
        $_SESSION['nombreArchivoBackup'] = substr($_POST['historial-backups'], 9);
        header('location: ../../login/login.php');
    }
}

