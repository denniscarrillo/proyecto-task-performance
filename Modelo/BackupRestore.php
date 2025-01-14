<?php
class BackupRestore {
    public static function generarBackup($url){
        // Definir los parámetros para la ejecución del respaldo
        $instancia = $_ENV['DB_HOST'];
        $BaseDeDatos = $_ENV['DB_NAME'];

        // Construir el comando de respaldo con autenticación de Windows
        $comandoBackup = "sqlcmd -S $instancia -E -Q \"BACKUP DATABASE $BaseDeDatos TO DISK='$url' WITH FORMAT\"";
        //Ejecutar el comando de respaldo
        $resultado = shell_exec($comandoBackup);
        // Verificar si el respaldo fue exitoso
        if ($resultado !== null) {
            return true;
        } else {
            return false;
        }
        
    }

    public static function generarRestore($url){
        // Definir los parámetros para la ejecución del respaldo
        $instancia = $_ENV['DB_HOST'];
        $BaseDeDatos = $_ENV['DB_NAME'];
        // Construir el comando de respaldo con autenticación de Windows
        $comandoRestore = "sqlcmd -S $instancia -E -Q \"USE master; IF EXISTS (SELECT name FROM sys.databases WHERE name = '$BaseDeDatos') BEGIN ALTER DATABASE $BaseDeDatos SET SINGLE_USER WITH ROLLBACK IMMEDIATE; END; DROP DATABASE $BaseDeDatos; RESTORE DATABASE $BaseDeDatos FROM DISK = '$url' WITH REPLACE, RECOVERY, STATS = 5;\"";
        //Ejecutar el comando de respaldo
        $resultado = shell_exec($comandoRestore);
        // Verificar si el respaldo fue exitoso
        if ($resultado !== null) {
            return true;
        } else {
            return false;
        }
    }

    public static function insertarHistorialBackup($url, $creadoPor){
        // Especificar la ruta del archivo JSON
        $ruta_archivo = './backupsURLs.json';
        // Cargar el contenido actual del archivo JSON
        $contenido_json = file_get_contents($ruta_archivo);
        // Decodificar el contenido JSON en un array PHP
        $datos_existente = json_decode($contenido_json, true);
        // Datos nuevos a agregar
        $nueva_url = array(
            "url" => $url,
            "creadoPor" => $creadoPor
        );
        // Agregar los nuevos datos al array existente
        $datos_existente[] = $nueva_url;
        // Convertir el array actualizado a JSON
        $json_actualizado = json_encode($datos_existente, JSON_PRETTY_PRINT);
        // Escribir la cadena JSON en el archivo
        if (file_put_contents($ruta_archivo, $json_actualizado)) {
            return true;
        } else {
            return false;
        }
    }

    public static function obtenerHistorialBackup(){
        // Especificar la ruta del archivo JSON
        $ruta_archivo = './backupsURLs.json';
        // Cargar el contenido actual del archivo JSON
        $contenido_json = file_get_contents($ruta_archivo);
        // Decodificar el contenido JSON en un array PHP
        $datos_existente = json_decode($contenido_json, true);
        return $datos_existente;
    } 

}