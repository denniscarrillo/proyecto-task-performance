<?php
   require_once("../../../db/Conexion.php");
   require_once("../../../Modelo/BackupRestore.php");
   require_once("../../../Controlador/ControladorBackupRestore.php");
   
   $data = ControladorBackupRestore::obtenerHistorialBackup();

   print json_encode($data, JSON_UNESCAPED_UNICODE);