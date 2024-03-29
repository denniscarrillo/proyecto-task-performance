<?php
class BackupRestore{
    public static function generarBackup($url){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
            $query = "exec bk_generarBackup '$url';";
            sqlsrv_query($conexion, $query);
            // if (sqlsrv_errors() == null) {
            //     return sqlsrv_errors();
            // }
            return sqlsrv_errors();
            sqlsrv_close($conexion); //Cerrar conexion
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
    }
    public static function insertarHistorialBackup($url, $creadoPor){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
        $query = "INSERT INTO tbl_historialBackup VALUES ('$url','$creadoPor', GETDATE());";
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
}