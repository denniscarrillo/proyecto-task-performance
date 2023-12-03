<?php
class razonSocial {
public $id_RazonSocial;
public $razon_Social;
public $descripcion;
public $CreadoPor;
public $FechaCreacion;


public static function obtenerTodasLasRazonSocial(){
    $razonSocial = array();
    try{
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $query = "SELECT id_razon_Social, razon_Social, descripcion FROM tbl_razon_Social;";
        $obtenerRazonSocial = sqlsrv_query($abrirConexion, $query);
        //Recorremos el resultado de tareas y almacenamos en el arreglo.
        while ($fila = sqlsrv_fetch_array( $obtenerRazonSocial, SQLSRV_FETCH_ASSOC)) {
            $razonSocial[] = [
                'id_razonSocial' => $fila["id_razon_Social"],
                'razon_Social' => $fila["razon_Social"],
                'descripcion' => $fila["descripcion"]
            ];
        }
    } catch (Exception $e) {
        $razonSocial = 'Error SQL:' .$e;
    }
    sqlsrv_close($abrirConexion); //Cerrar conexion
    return $razonSocial;
}

public static function nuevaRazonSocial($nuevaRazonSocial){
    try{
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $razonSocial = $nuevaRazonSocial->razon_Social;
        $descripcion = $nuevaRazonSocial->descripcion;
        $CreadoPor = $nuevaRazonSocial->CreadoPor;
        $query = "INSERT INTO tbl_razon_Social (razon_Social, descripcion, Creado_Por, Fecha_Creacion) VALUES ('$razonSocial', '$descripcion', '$CreadoPor', GETDATE());";
        sqlsrv_query($abrirConexion, $query);
    } catch (Exception $e) {
        echo 'Error SQL:' . $e;
    }
    sqlsrv_close($abrirConexion); #Cerramos la conexión.
    return $nuevaRazonSocial;
 }

 public static function editarRazonSocial($nuevaRazonSocial){
    try {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $id_RazonSocial=$nuevaRazonSocial->id_RazonSocial;
        $razon_Social=$nuevaRazonSocial->razon_Social;
        $descripcion=$nuevaRazonSocial->descripcion;
        $query ="UPDATE tbl_razon_Social SET razon_Social ='$razon_Social', descripcion ='$descripcion'
                WHERE id_razon_Social ='$id_RazonSocial';";
        $nuevaRazonSocial = sqlsrv_query($abrirConexion, $query);
    } catch (Exception $e) {
        echo 'Error SQL:' . $e;
    }
    sqlsrv_close($abrirConexion); //Cerrar conexion
    return $nuevaRazonSocial;
}

public static function eliminarRazonSocial($idRazonSocial){
    try{
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $estadoEliminado = false; 
        $query = "DELETE FROM tbl_razon_Social WHERE id_razon_Social = '$idRazonSocial';";
        if(sqlsrv_rows_affected(sqlsrv_query($conexion, $query)) > 0){
            $estadoEliminado = true;
        }
    } catch (Exception $e) {
        echo 'Error SQL:' . $e;
    }
    sqlsrv_close($conexion); //Cerrar conexion
    return $estadoEliminado;
}
public static function RazonSocialExistente($razonSocial){
    $existeRazonSocial = false;
    $conn = new Conexion();
    $conexion = $conn->abrirConexionDB();
    $query = "SELECT razon_Social FROM tbl_razon_Social WHERE razon_Social = '$razonSocial'";
    $razonSociall = sqlsrv_query($conexion, $query);
    $existe = sqlsrv_has_rows($razonSociall);
    if($existe){
        $existeRazonSocial = true;
    }
    sqlsrv_close($conexion); #Cerramos la conexión.
    return $existeRazonSocial;
}
public static function obtenerPdfRazonSocial($buscar){
    $razonSocial = array();
    try{
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $query = "SELECT id_razon_Social, razon_Social, descripcion FROM tbl_razon_Social WHERE CONCAT(id_razon_Social, razon_Social, descripcion) LIKE '%' + '$buscar' + '%';";
        $obtenerRazonSocial = sqlsrv_query($abrirConexion, $query);
        //Recorremos el resultado de tareas y almacenamos en el arreglo.
        while ($fila = sqlsrv_fetch_array( $obtenerRazonSocial, SQLSRV_FETCH_ASSOC)) {
            $razonSocial[] = [
                'id_razonSocial' => $fila["id_razon_Social"],
                'razon_Social' => $fila["razon_Social"],
                'descripcion' => $fila["descripcion"]
            ];
        }
    } catch (Exception $e) {
        $razonSocial = 'Error SQL:' .$e;
    }
    sqlsrv_close($abrirConexion); //Cerrar conexion
    return $razonSocial;
}
}

?>