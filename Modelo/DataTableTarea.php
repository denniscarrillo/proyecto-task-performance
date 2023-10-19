<?php

class DataTableTarea
{
    public $idTarea;
    public $idEstadoAvance;
    public $titulo;
    public $descripcion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerTareas($User)
    {
        $tareasUsuario = null;
        try {
            $tareasUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $consultaridUser ="SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$User'";
            $resultadoId = sqlsrv_query($abrirConexion, $consultaridUser);
            $filaId = sqlsrv_fetch_array($resultadoId, SQLSRV_FETCH_ASSOC);
            $idUser = $filaId['id_Usuario'];
            $query = "SELECT t.id_Tarea, t.titulo, e.descripcion as Estado_Tarea, t.estado_Finalizacion  FROM tbl_vendedores_tarea
            AS vt
            INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea
            INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
            WHERE vt.id_usuario_vendedor = '$idUser'";

            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $tareasUsuario[] = [
                    'id_Tarea' => $fila['id_Tarea'],
                    'titulo' => $fila['titulo'],
                    'descripcion' => $fila['Estado_Tarea'],
                    'estado_Finalizacion' => $fila['estado_Finalizacion']
                ];
            }
        } catch (Exception $e) {
            $tareasUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tareasUsuario;
    } 
}