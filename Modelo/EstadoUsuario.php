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


    public static function editarEstadoU($editarEstado) {
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); // Abrir conexión a la base de datos
            $id = $editarEstado->idEstado;
            $descrip = $editarEstado->descripcion;
            $modificadoPor = $editarEstado->modificadoPor;
            $query = "UPDATE tbl_Estado_Usuario SET descripcion ='$descrip', Modificado_Por='$modificadoPor', 
            Fecha_Modificacion = GETDATE() WHERE id_Estado_Usuario='$id' AND descripcion 
            NOT IN('NUEVO','ACTIVO', 'INACTIVO', 'BLOQUEADO', 'VACACIONES');";
            
            // Ejecutar la consulta
            $editarEstado = sqlsrv_query($abrirConexion, $query);
    
            // Cerrar la conexión a la base de datos
            sqlsrv_close($abrirConexion);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e->getMessage(); // Mostrar mensaje de error
        }
    }

    public static function eliminarEstadoU($idEstadoU){
        try {
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_Estado_Usuario WHERE id_Estado_Usuario = '$idEstadoU' 
                AND descripcion NOT IN('NUEVO','ACTIVO', 'INACTIVO', 'BLOQUEADO', 'VACACIONES');";
            $estadoEliminado = sqlsrv_query($conexion, $query);
            if ($estadoEliminado === false) {
                return false;
            }
            $rowsAffected = sqlsrv_rows_affected($estadoEliminado);
            if ($rowsAffected == 0) {
                return false; // No hay filas afectadas, no se elimina nada
            }
            sqlsrv_close($conexion); // Close the connection
            return true;
        } catch (Exception $e) {
            // Handle other exceptions if needed
            $estadoEliminado = 'Error SQL:' . $e;
            return false;
        }
    }
    
}