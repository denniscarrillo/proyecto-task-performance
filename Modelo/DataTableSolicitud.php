<?php

class DataTableSolicitud
{
    public $idSolicitud;
    public $idTipoSolicitud;
    public $EstadoAvance;
    public $EstadoSolicitud;
    public $TelefonoCliente;
    public $FechaCreacion;
    public $MotivoCancelacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerSolicitud($User)
    {
        $SolicitudesUsuario = null;
        try {
            $SolicitudesUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT s.id_Solicitud, 
            t.servicio_Tecnico, 
            -- cc.nombre_Cliente,
            s.telefono_cliente,
            s.EstadoAvance,
            s.EstadoSolicitud,
            s.motivo_cancelacion,
            s.Fecha_Creacion
            FROM tbl_Solicitud AS s
            INNER JOIN tbl_TipoServicio AS t ON t.id_TipoServicio = s.id_TipoServicio
            -- INNER JOIN tbl_CarteraCliente AS cc ON cc.id_CarteraCliente = s.id_Solicitud
            -- INNER JOIN View_FACTURASVENTA AS f ON f.NUMFACTURA = s.idFactura
            -- INNER JOIN View_Clientes AS c ON c.CODCLIENTE = f.CODCLIENTE
            WHERE s.Creado_Por = '$User';";

           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $SolicitudesUsuario[] = [
                    'id_Solicitud' => $fila['id_Solicitud'],
                    'servicio_Tecnico' => $fila['servicio_Tecnico'],
                    // 'Nombre' => $fila['nombre_Cliente'],
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


    public static function actualizarEstadoSolicitud($nuevaSolicitud){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $idSolicitud=$nuevaSolicitud->idSolicitud;
            $EstadoSolicitud=$nuevaSolicitud->EstadoSolicitud;
            $MotivoCancelacion=$nuevaSolicitud->MotivoCancelacion;
            $modificadoPor=$nuevaSolicitud->modificadoPor;
            // date_default_timezone_set('America/Tegucigalpa'); 
            // $fechaModificado = date("Y-m-d h:i:s");
            $query ="UPDATE tbl_Solicitud SET EstadoSolicitud='$EstadoSolicitud', motivo_cancelacion = '$MotivoCancelacion', 
            Modificado_Por='$modificadoPor', Fecha_Modificacion = GETDATE()
            WHERE id_Solicitud='$idSolicitud';";
            $nuevaSolicitud = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion

    }



}

