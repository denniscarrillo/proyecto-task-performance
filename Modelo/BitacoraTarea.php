<?php
class BitacoraTarea
{
    public static function agregarComentarioTarea($idTarea, $comentario, $CreadoPor){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "INSERT INTO tbl_Comentarios_Tarea (id_Tarea, Comentario, Creado_Por, Fecha_Creacion) VALUES ('$idTarea', '$comentario', '$CreadoPor', GETDATE());";
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion);
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
    public static function acciones_Evento_Tareas(){
        $accionesTarea = [
            'creación' => '',
            'nuevoComentario' => 'Agrego un comentario',
            'Update' => 'Actualizacion'
        ];
        return $accionesTarea;
    }
    /*
    *** Método de captura los eventos sobre el modulo de RENDIMIENTO y los almacena en la base de datos
    *** en la tabla TBL_BITACORA_TAREA
    */
    public static function SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser){
        //Recibir objeto y obtener parametros
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $ejecutarSQL = "INSERT INTO tbl_Bitacora_Tarea (id_Tarea, id_Usuario, accion, descripcion, fecha)
        VALUES('$eventoTarea->idTarea', '$idUser', '$eventoTarea->accionEvento', '$eventoTarea->descripcionEvento', GETDATE());";
        $ejecutarSQL = sqlsrv_query($conexion, $ejecutarSQL);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
    public static function consultarBitacoraTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT mu.usuario, bt.descripcion, bt.fecha, co.Comentario FROM tbl_Bitacora_Comentarios bc
        INNER JOIN tbl_Bitacora_Tarea bt ON bc.id_Bitacora = bt.id_Bitacora_Tarea
        INNER JOIN tbl_Comentarios_Tarea co ON co.id_Comentario = bc.id_Comentario
        INNER JOIN tbl_MS_Usuario mu ON bt.id_Usuario = mu.id_Usuario
        WHERE bt.id_Tarea = '$idTarea' ORDER BY bt.fecha DESC;";
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
}



