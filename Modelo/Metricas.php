<?php
class Metricas{
    public $idMetrica;
    public $idEstadoAvance;
    public $meta;

    public static function obtenerTodasLasMetricas(){
        $metricas = null;
        try {
            $metricas = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $resultado = $abrirConexion->query("SELECT m.id_Metrica,e.descripcion,m.meta FROM tbl_metrica as m
            inner join tbl_estadoavance AS e ON m.id_EstadoAvance = e.id_EstadoAvance;");
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = $resultado->fetch_assoc()) {
                $metricas[] = [
                    'idMetrica' => $fila['id_Metrica'],
                    'descripcion' => $fila['descripcion'],
                    'meta' => $fila['meta'],
                ];
            }
        } catch (Exception $e) {
            $metricas = 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
        return $metricas;
    }

    public static function editarMetrica($nuevaMetrica){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevaMetrica->idMetrica;
            $meta=$nuevaMetrica->meta;
            $update ="UPDATE tbl_metrica SET meta='$meta' WHERE id_Metrica='$id';";
            $ejecutar_update = mysqli_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
}#Fin de la clase
