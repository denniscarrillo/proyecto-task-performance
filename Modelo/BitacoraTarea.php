<?php
class BitacoraTarea
{
    public $idTarea;
    public $descripcionEvento;
        
    public static function agregarComentarioTarea($idTarea, $comentario, $CreadoPor){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "INSERT INTO tbl_Comentarios_Tarea (id_Tarea, Comentario, Creado_Por, Fecha_Creacion) VALUES ('$idTarea', '$comentario', '$CreadoPor', GETDATE());";
        sqlsrv_query($conexion, $query);
        $query = "SELECT SCOPE_IDENTITY() AS id_Comentario";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $idComentario = $fila['id_Comentario'];
        sqlsrv_close($conexion);
        return $idComentario;
    }
    public static function mostrarComentariosTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT Comentario, Creado_Por, Fecha_Creacion FROM tbl_Comentarios_Tarea WHERE id_Tarea = '$idTarea' ORDER BY Fecha_Creacion DESC;";
        $resultado = sqlsrv_query($conexion, $query);
        $comentariosTarea = array();
        while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
            $comentariosTarea [] = [
                'comentarioTarea' => $fila['Comentario'],
                'creadoPor' => $fila['Creado_Por'],
                'FechaCreacion' => $fila['Fecha_Creacion']
            ];
        }
        sqlsrv_close($conexion);
        return $comentariosTarea;
    }
    /*
    *** Método de captura los eventos sobre el modulo de RENDIMIENTO y los almacena en la base de datos
    *** en la tabla TBL_BITACORA_TAREA
    */
    public static function SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser){
        //Recibir objeto y obtener parametros
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $ejecutarSQL = "INSERT INTO tbl_Bitacora_Tarea (id_Tarea, id_Usuario, descripcion, fecha)
        VALUES('$eventoTarea->idTarea', '$idUser', '$eventoTarea->descripcionEvento', GETDATE());";
        sqlsrv_query($conexion, $ejecutarSQL);
        $query = "SELECT SCOPE_IDENTITY() AS id_Bitacora_Tarea";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $idBitacora = $fila['id_Bitacora_Tarea'];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $idBitacora;
    }
    public static function guardarBitacoraComentario($idBitacora, $idComentario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $ejecutarSQL = "INSERT INTO tbl_Bitacora_Comentarios VALUES('$idBitacora','$idComentario');";
        sqlsrv_query($conexion, $ejecutarSQL);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
    public static function consultarBitacoraTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT mu.usuario, bt.descripcion, bt.fecha, co.Comentario
        FROM tbl_Bitacora_Tarea bt
        INNER JOIN tbl_MS_Usuario mu ON bt.id_Usuario = mu.id_Usuario
        LEFT JOIN tbl_Bitacora_Comentarios bc ON bt.id_Bitacora_Tarea = bc.id_Bitacora
        LEFT JOIN tbl_Comentarios_Tarea co ON bc.id_Comentario = co.id_Comentario
        WHERE bt.id_Tarea = '$idTarea'
        ORDER BY bt.fecha DESC;";
        $ejecutar = sqlsrv_query($conexion, $query);
        $historialTarea = array();
        while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
            $historialTarea[] = [
                'usuarioTarea' => $fila['usuario'],
                'descripcion' => $fila['descripcion'],
                'fecha' => $fila['fecha'],
                'comentario' => $fila['Comentario']
            ];
        }
        sqlsrv_close($conexion);
        return $historialTarea;
    }
    public static function obtenerEstadoTarea($idEstado){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT descripcion FROM tbl_EstadoAvance WHERE id_EstadoAvance = '$idEstado';";
        $estado = sqlsrv_fetch_array(sqlsrv_query($conexion, $query), SQLSRV_FETCH_ASSOC);
        $estado = $estado['descripcion'];
        sqlsrv_close($conexion);
        return $estado;
    }
    public static function obtenerEstadoAvanceTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT ea.descripcion FROM tbl_Tarea ta
        INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
        WHERE ta.id_Tarea = '$idTarea';";
        $estado = sqlsrv_fetch_array(sqlsrv_query($conexion, $query), SQLSRV_FETCH_ASSOC);
        $estado = $estado['descripcion'];
        sqlsrv_close($conexion);
        return $estado;
    }
    public static function obtenerUsuario($idUsuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT usuario FROM tbl_MS_Usuario WHERE id_Usuario = '$idUsuario';";
        $usuario = sqlsrv_fetch_array(sqlsrv_query($conexion, $query), SQLSRV_FETCH_ASSOC);
        $usuario = $usuario['usuario'];
        sqlsrv_close($conexion);
        return $usuario;
    }
    public static function obtenerTareaCotizacion($idCotizacion){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Tarea,estado_Cotizacion FROM tbl_CotizacionTarea WHERE id_Cotizacion = '$idCotizacion';";
        $ejecutar = sqlsrv_query($conexion, $query);
        $tarea = array();
        while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
            $tarea [] = [
                'id' => $fila['id_Tarea'],
                'estado' => $fila['estado_Cotizacion']
            ];
        }
        sqlsrv_close($conexion);
        return $tarea;
    }
}