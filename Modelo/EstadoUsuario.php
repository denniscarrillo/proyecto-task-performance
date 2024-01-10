<?php

class EstadoUsuario{
    public $idEstadoUsuario;
    public $descripcionEstado;
    public $creadoPor;
    public $fechaCreacion;
    public $modificadoPor;
    public $fechaModificacion;
    
    public static function obtenerEstadoUsuario(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Estado_Usuario, descripcion, Creado_Por, Fecha_Creacion FROM tbl_Estado_Usuario;";
        $estadoUsuario = sqlsrv_query($conexion, $query);
        $estados = array();
        while ($fila = sqlsrv_fetch_array($estadoUsuario, SQLSRV_FETCH_ASSOC)) {
            $estados [] = [
                'idEstado' => $fila['id_Estado_Usuario'],
                'estado' => $fila['descripcion'],
                'CreadoPor' => $fila['Creado_Por'],
                'FechaCreacion' => $fila['Fecha_Creacion']
            ];
        }
        sqlsrv_close($conexion);
        return $estados;
    }
    public static function InsertarNuevoEstado($estado, $usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $estadoInsert = false;
        $query = "INSERT INTO tbl_Estado_Usuario (descripcion, Creado_Por, Fecha_Creacion) 
        VALUES  ('$estado', '$usuario', GETDATE());";
        if(sqlsrv_rows_affected(sqlsrv_query($conexion, $query)) > 0){
            $estadoInsert = true;
        }
        sqlsrv_close($conexion);
        return $estadoInsert;
    }
}