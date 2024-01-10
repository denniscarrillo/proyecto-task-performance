<?php
class TipoServicio {

    public $id_TipoServicio;
    public $servicio_Tecnico;
    //Campos de auditoria
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    //obtener datos de tipo servicio
    public static function obtenerTodosLosTipoServicio(){
        $tipoServicio = array();
        try{
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB();
            $query = "SELECT id_TipoServicio, servicio_Tecnico FROM tbl_TipoServicio;";
            $obtenerTipoServicio = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array( $obtenerTipoServicio, SQLSRV_FETCH_ASSOC)) {
                $tipoServicio[] = [
                    'id_TipoServicio' => $fila["id_TipoServicio"],
                    'servicio_Tecnico' => $fila["servicio_Tecnico"]
                ];
            }
        } catch (Exception $e) {
            $tipoServicio = 'Error SQL:' .$e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tipoServicio;
    }

    public static function registroTipoServicio($nuevoTipoServicio) {
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $servicio_Tecnico=$nuevoTipoServicio->servicio_Tecnico;
            $CreadoPor=$nuevoTipoServicio->creadoPor;
            date_default_timezone_set('America/Tegucigalpa');
            $FechaCreacion = date("Y-m-d");
            $insert = "INSERT INTO tbl_TipoServicio (servicio_Tecnico,  Creado_Por, Fecha_Creacion) 
                        VALUES ('$servicio_Tecnico', '$CreadoPor', '$FechaCreacion');";
            $ejecutar_insert = sqlsrv_query($abrirConexion, $insert);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); #Cerramos la conexión.
    }

    public static function editarTipoServicio($nuevaTipoServicio){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id_TipoServicio=$nuevaTipoServicio->id_TipoServicio;
            $servicio_Tecnico=$nuevaTipoServicio->servicio_Tecnico;
            $ModificadoPor=$nuevaTipoServicio->modificadoPor;
            date_default_timezone_set('America/Tegucigalpa'); 
            $FechaModificacion = date("Y-m-d");
            $query ="UPDATE tbl_TipoServicio SET servicio_Tecnico ='$servicio_Tecnico', 
                    Modificado_Por='$ModificadoPor', Fecha_Modificacion= ' $FechaModificacion' 
                    WHERE id_TipoServicio ='$id_TipoServicio';";
            $nuevaTipoServicio = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }

    public static function eliminarTipoServicio($TipoServicio){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_TipoServicio WHERE id_TipoServicio = '$TipoServicio';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }

    //Generado por PDF
    public static function obtenerTipoServicioID($id){
        $tipoServicio = array();
        try{
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB();
            $query = "SELECT servicio_Tecnico FROM tbl_TipoServicio
            WHERE id_TipoServicio = '$id';";
            $obtenerTipoServicio = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array( $obtenerTipoServicio, SQLSRV_FETCH_ASSOC)) {
                $tipoServicio[] = [
                    'servicioTec' => $fila["servicio_Tecnico"]
                ];
            }
        } catch (Exception $e) {
            $tipoServicio = 'Error SQL:' .$e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tipoServicio;
    }

    //Generado por PDF
    public static function obtenerTipoServicioPDF($buscar){
        $tipoServicio = array();
        try{
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB();
            $query = "SELECT id_TipoServicio, servicio_Tecnico FROM tbl_TipoServicio
            WHERE CONCAT(id_TipoServicio, servicio_Tecnico) LIKE '%' + '$buscar' + '%';";
            $obtenerTipoServicio = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array( $obtenerTipoServicio, SQLSRV_FETCH_ASSOC)) {
                $tipoServicio[] = [
                    'id_TipoServicio' => $fila["id_TipoServicio"],
                    'servicio_Tecnico' => $fila["servicio_Tecnico"]
                ];
            }
        } catch (Exception $e) {
            $tipoServicio = 'Error SQL:' .$e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tipoServicio;
    }
}//Fin de la clase