<?php

class DataTableSolicitud
{
    public $idSolicitud;
    public $idTipoSolicitud;
    public $EstadoAvance;
    public $EstadoSolicitud;
    public $TelefonoCliente;
    public $FechaCreacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerSolicitud($User)
    {
        $SolicitudesUsuario = null;
        try {
            $SolicitudesUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT s.id_Solicitud, t.servicio_Tecnico, s.telefono_cliente,s.EstadoAvance,s.EstadoSolicitud,s.motivo_cancelacion,s.Fecha_Creacion
            FROM tbl_Solicitud AS s
            INNER JOIN tbl_TipoServicio AS t ON t.id_TipoServicio = s.id_TipoServicio
             WHERE s.Creado_Por = '$User';";
           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $SolicitudesUsuario[] = [
                    'id_Solicitud' => $fila['id_Solicitud'],
                    'servicio_Tecnico' => $fila['servicio_Tecnico'],
                    'telefono_cliente' => $fila['telefono_cliente'],
                    'EstadoAvance' => $fila['EstadoAvance'],
                    'EstadoSolicitud' => $fila['EstadoSolicitud'],
                    'motivo_cancelacion' => $fila['motivo_cancelacion'],
                    'Fecha_Creacion' => $fila['Fecha_Creacion']
                   
                ];
            }
        } catch (Exception $e) {
            $SolicitudesUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $SolicitudesUsuario;
    } 
}