<?php
class Metricas{
    public $idMetrica;
    public $idEstadoAvance;
    public $meta;
    public $modificadoPor;
    public $fechaModificacion;

    public static function obtenerTodasLasMetricas(){
        $metricas = null;
        try {
            $metricas = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT m.id_Metrica,e.descripcion,m.meta FROM tbl_metrica as m
            inner join tbl_estadoavance AS e ON m.id_EstadoAvance = e.id_EstadoAvance;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC)) {
                $metricas[] = [
                    'idMetrica' => $fila['id_Metrica'],
                    'descripcion' => $fila['descripcion'],
                    'meta' => $fila['meta'],
                ];
            }
        } catch (Exception $e) {
            $metricas = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $metricas;
    }

    public static function editarMetrica($nuevaMetrica){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevaMetrica->idMetrica;
            $meta=$nuevaMetrica->meta;
            $modificadoPor=$nuevaMetrica->modificadoPor;
            $fechaModificacion=$nuevaMetrica->fechaModificacion;
            $query ="UPDATE tbl_metrica SET meta='$meta', Modificado_Por='$modificadoPor', Fecha_Modificacion='$fechaModificacion' WHERE id_Metrica='$id';";
            $nuevaMetrica = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerEstadoAvance($idMetrica){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="  SELECT ea.descripcion FROM tbl_Metrica me
        INNER JOIN tbl_EstadoAvance ea ON me.id_EstadoAvance = ea.id_EstadoAvance
        WHERE me.id_EstadoAvance = '$idMetrica';";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $estadoAvance = $fila['descripcion'];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoAvance;
    }
}#Fin de la clase
