<?php
class BackupRestore{
    public static function generarBackup($url){
        // Definir los parámetros para la ejecución del respaldo
        $BaseDeDatos = 'RENDIMIENTO_TAREAS';
        $usuario = 'TANIAC';
        $password = 'password';
        $rutaArchivoBackup = $url;
        // Construir el comando de respaldo
        $comando = "sqlcmd -S DESKTOP-REQKDIP\SQLEXPRESS -U $usuario -P $password -Q \"BACKUP DATABASE $BaseDeDatos TO DISK='$rutaArchivoBackup' WITH FORMAT\"";
        // Ejecutar el comando de respaldo
        $resultado = shell_exec($comando);
        // Verificar si el respaldo fue exitoso
        if ($resultado !== null) {
            return true;
        } else {
            return false;
        }

    }


    // public static function insertarHistorialBackup($url, $creadoPor){
        //     $conn = new Conexion();
        //     $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
        //     $query = "INSERT INTO tbl_historialBackup VALUES ('$url','$creadoPor', GETDATE());";
        //     sqlsrv_query($conexion, $query);
        //     sqlsrv_close($conexion); #Cerramos la conexión.
        // }
    }
    
                // $query = "BACKUP DATABASE RENDIMIENTO_TAREAS TO DISK = 'C:\BACKUPS\RespaldoRENDIMIENTO_TAREA.bak'";