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
            $query = "SELECT e.id_EstadoAvance,e.descripcion,m.meta FROM tbl_metrica as m
            inner join tbl_estadoavance AS e ON m.id_EstadoAvance = e.id_EstadoAvance;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC)) {
                $metricas[] = [
                    'id_EstadoAvance' => $fila['id_EstadoAvance'],
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
            $query ="UPDATE tbl_metrica SET meta='$meta', Modificado_Por='$modificadoPor', Fecha_Modificacion = GETDATE() WHERE  id_EstadoAvance='$id';";
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



    public static function obtenerMetas() {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); // Abrimos la conexión a la DB.   
        // Consulta para obtener la meta
        $query = "SELECT id_EstadoAvance, meta FROM tbl_Metrica";
        $resultMeta = sqlsrv_query($abrirConexion, $query);    
        $meta = array(); // Inicializamos la variable $meta en 0
    
        while ($fila = sqlsrv_fetch_array($resultMeta, SQLSRV_FETCH_ASSOC)) {
            // Sumamos todas las metas obtenidas de la consulta
            $meta [] = [ 
                "id_EstadoAvenace" => $fila ['id_EstadoAvance'],
                "meta" => $fila ['meta']
            ];
        }  
        sqlsrv_close($abrirConexion);            
        return $meta;
    }

    public static function eliminarMetrica($metrica){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_estadoavance WHERE id_EstadoAvance = '$metrica';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
            if(!$estadoEliminado) {
                return false;
            }
            sqlsrv_close($conexion); //Cerrar conexion
            return true;
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
    }
    
    public static function obtenerLasMetricasPDF($buscar){
        $metricas = null;
        try {
            $metricas = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT m.id_Metrica,e.descripcion,m.meta FROM tbl_metrica as m
            inner join tbl_estadoavance AS e ON m.id_EstadoAvance = e.id_EstadoAvance
            WHERE CONCAT(m.id_Metrica,e.descripcion,m.meta) LIKE '%' + '$buscar' + '%';";
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

    public static function obtenerEstadisticas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT E.descripcion, M.meta, COUNT(*) AS Alcance,
        CONCAT(CAST(COUNT(*) * 100.0 / M.meta AS DECIMAL(10,0)), '%') AS Porcentaje
   FROM tbl_Metrica AS M
   INNER JOIN tbl_EstadoAvance AS E ON M.id_EstadoAvance = E.id_EstadoAvance
   INNER JOIN tbl_Tarea AS T ON T.id_EstadoAvance = E.id_EstadoAvance
   GROUP BY E.descripcion, M.meta;";

        $resultado = sqlsrv_query($consulta, $query);
        $estadisticas = array();
        while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
            $estadisticas [] = [
                'Descripcion' => $fila['descripcion'],
                'Meta' => $fila['meta'],
                'Alcance' => $fila['Alcance'],
                'Porcentaje' => $fila['Porcentaje']
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $estadisticas;
    }


    public static function obtenerEstadisticasGeneral($FechaInicial, $FechaFinal){
        $estadisticasG = null;
        try {
            $estadisticasG = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT E.descripcion, M.meta, COUNT(*) AS Alcance,
                      CONCAT(CAST(COUNT(*) * 100.0 / M.meta AS DECIMAL(10,0)), '%') AS Porcentaje
                      FROM tbl_Metrica AS M
                      INNER JOIN tbl_EstadoAvance AS E ON M.id_EstadoAvance = E.id_EstadoAvance
                        INNER JOIN tbl_Tarea AS T ON T.id_EstadoAvance = E.id_EstadoAvance
                        WHERE T.fecha_Finalizacion BETWEEN '$FechaInicial' AND '$FechaFinal'
                        GROUP BY E.descripcion, M.meta;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $estadisticasG[] = [
                    'Descripcion' => $fila['descripcion'],
                    'Meta' => $fila['meta'],
                    'Alcance' => $fila['Alcance'],
                    'Porcentaje' => $fila['Porcentaje']
                ];
            }
        } catch (Exception $e) {
            $estadisticasG = 'Error SQL:' . $e;
        } finally {
            if ($abrirConexion !== null) {
                sqlsrv_close($abrirConexion); // Cierra la conexión en el bloque finally
            }
        
            }
        // sqlsrv_close($abrirConexion); //Cerrar conexion
        return $estadisticasG;
    }

    public static function obtenerEstadisticasPorVed($idUsuario, $FechaInicial, $FechaFinal){
        $estadisticasV = null;
        try {
            $estadisticasV = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT E.descripcion, M.meta, COUNT(*) AS Alcance,
                            CONCAT(CAST(COUNT(*) * 100.0 / M.meta AS DECIMAL(10,0)), '%') AS Porcentaje
                        FROM tbl_Metrica AS M
                        INNER JOIN tbl_EstadoAvance AS E ON M.id_EstadoAvance = E.id_EstadoAvance
                        INNER JOIN tbl_Tarea AS T ON T.id_EstadoAvance = E.id_EstadoAvance
                        INNER JOIN tbl_vendedores_tarea AS VT ON VT.id_Tarea = T.id_Tarea
                        INNER JOIN tbl_MS_Usuario AS U ON u.id_Usuario = VT.id_usuario_vendedor
                        WHERE T.fecha_Finalizacion BETWEEN '$FechaInicial' AND '$FechaFinal' AND id_Usuario = '$idUsuario'
                        GROUP BY E.descripcion, M.meta;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $estadisticasV[] = [
                    'Descripcion' => $fila['descripcion'],
                    'Meta' => $fila['meta'],
                    'Alcance' => $fila['Alcance'],
                    'Porcentaje' => $fila['Porcentaje']
                ];
            }
        } catch (Exception $e) {
            $estadisticasV = 'Error SQL:' . $e;
        } finally {
            if ($abrirConexion !== null) {
                sqlsrv_close($abrirConexion); // Cierra la conexión en el bloque finally
            }
        
            }
        return $estadisticasV;
    }


    

    

}#Fin de la clase


