<?php

class ControladorBackupRestore {
    public static function generarBackup($url){
        return BackupRestore::generarBackup($url);
    }
    // public static function insertarHistorialBackup($url, $creadoPor){
    //     return BackupRestore::insertarHistorialBackup($url, $creadoPor);
    // }
}    