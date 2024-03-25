<?php
class rubroComercial {
public $id_RubroComercial;
public $rubro_Comercial;
public $descripcion;
public $CreadoPor;
public $FechaCreacion;


public static function obtenerTodosLosRubrosComerciales(){
    $rubroComercial = array();
    try{
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $query = "SELECT id_rubro_Comercial, rubro_Comercial, descripcion FROM tbl_rubro_Comercial;";
        $obtenerRazonSocial = sqlsrv_query($abrirConexion, $query);
        //Recorremos el resultado de tareas y almacenamos en el arreglo.
        while ($fila = sqlsrv_fetch_array( $obtenerRazonSocial, SQLSRV_FETCH_ASSOC)) {
            $rubroComercial[] = [
                'id_rubroComercial' => $fila["id_rubro_Comercial"],
                'rubro_Comercial' => $fila["rubro_Comercial"],
                'descripcion' => $fila["descripcion"]
            ];
        }
    } catch (Exception $e) {
        $rubroComercial = 'Error SQL:' .$e;
    }
    sqlsrv_close($abrirConexion); //Cerrar conexion
    return $rubroComercial;
}

public static function nuevoRubroComercial($nuevoRubroComercial){
    try{
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $rubroComercial = $nuevoRubroComercial->rubro_Comercial;
        $descripcion = $nuevoRubroComercial->descripcion;
        $CreadoPor = $nuevoRubroComercial->CreadoPor;
        $query = "INSERT INTO tbl_rubro_Comercial (rubro_Comercial, descripcion, Creado_Por, Fecha_Creacion) VALUES ('$rubroComercial', '$descripcion', '$CreadoPor', GETDATE());";
        sqlsrv_query($abrirConexion, $query);
    } catch (Exception $e) {
        echo 'Error SQL:' . $e;
    }
    sqlsrv_close($abrirConexion); #Cerramos la conexión.
    return $nuevoRubroComercial;
 }

 public static function editarRubroComercial($nuevoRubroComercial){
    try {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $id_rubroComercial =$nuevoRubroComercial->id_RubroComercial;
        $rubroComercial =$nuevoRubroComercial->rubro_Comercial;
        $descripcion =$nuevoRubroComercial->descripcion;
        $query ="UPDATE tbl_rubro_Comercial SET rubro_Comercial ='$rubroComercial', descripcion ='$descripcion'
                WHERE id_rubro_Comercial ='$id_rubroComercial';";
        sqlsrv_query($abrirConexion, $query);
    } catch (Exception $e) {
        echo 'Error SQL:' . $e;
    }
    sqlsrv_close($abrirConexion); //Cerrar conexion
    return $nuevoRubroComercial;
}

public static function eliminarRubroComercial($idRubroComercial){
    try{
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $estadoEliminado = false;
        $query = "DELETE FROM tbl_rubro_Comercial WHERE id_rubro_Comercial = '$idRubroComercial';";
        if(sqlsrv_rows_affected(sqlsrv_query($conexion, $query)) > 0){
            $estadoEliminado = true;
        }
    } catch (Exception $e) {
        echo 'Error SQL:' . $e;
    }
    sqlsrv_close($conexion); //Cerrar conexion
    return $estadoEliminado;
}
public static function RubroComercialExistente($rubroComercial){
    $existeRubroComercial = false;
    $conn = new Conexion();
    $conexion = $conn->abrirConexionDB();
    $query = "SELECT rubro_Comercial FROM tbl_rubro_Comercial WHERE rubro_Comercial = '$rubroComercial'";
    $rubroComerciall = sqlsrv_query($conexion, $query);
    $existe = sqlsrv_has_rows($rubroComerciall);
    if($existe){
        $existeRubroComercial = true;
    }
    sqlsrv_close($conexion); #Cerramos la conexión.
    return $existeRubroComercial;
}
public static function obtenerPdfRubroComercial($buscar){
    $rubroComercial = array();
    try{
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $query = "SELECT id_rubro_Comercial, rubro_Comercial, descripcion FROM tbl_rubro_Comercial WHERE CONCAT(id_rubro_Comercial, rubro_Comercial, descripcion) LIKE '%' + '$buscar' + '%';";
        $obtenerRubroComercial = sqlsrv_query($abrirConexion, $query);
        //Recorremos el resultado de tareas y almacenamos en el arreglo.
        while ($fila = sqlsrv_fetch_array( $obtenerRubroComercial, SQLSRV_FETCH_ASSOC)) {
            $rubroComercial[] = [
                'id_rubroComercial' => $fila["id_rubro_Comercial"],
                'rubro_Comercial' => $fila["rubro_Comercial"],
                'descripcion' => $fila["descripcion"]
            ];
        }
    } catch (Exception $e) {
        $rubroComercial = 'Error SQL:' .$e;
    }
    sqlsrv_close($abrirConexion); //Cerrar conexion
    return $rubroComercial;
}
}

?>