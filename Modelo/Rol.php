<?php

class Rol {
    public $id_Rol;
    public $rol;
    public $descripcion;
    public $creadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    public static function obtenerRolesUsuario(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT id_Rol, rol, descripcion FROM tbl_ms_roles";
        $obtenerRoles = sqlsrv_query($consulta, $query);
        $roles = array();
        while($fila = sqlsrv_fetch_array($obtenerRoles, SQLSRV_FETCH_ASSOC)){
            $roles [] = [
                'id_Rol' => $fila["id_Rol"],
                'rol' => $fila["rol"],
                'descripcion' => $fila["descripcion"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $roles;
    }

    public static function registroRol($nuevoRol) {
        $rol = array();
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $rol=$nuevoRol->rol;
            $descripcion=$nuevoRol->descripcion;
            $creadoPor=$nuevoRol->creadoPor;
            date_default_timezone_set('America/Tegucigalpa');
            $fechaCreacion = date("Y-m-d");
            $insert = "INSERT INTO tbl_ms_roles (rol, descripcion, Creado_Por, Fecha_Creacion) VALUES ('$rol','$descripcion', '$creadoPor', '$fechaCreacion');";
            $ejecutar_insert = sqlsrv_query($abrirConexion, $insert);
            $query = "SELECT SCOPE_IDENTITY() AS id_Rol";
            $resultado = sqlsrv_query($abrirConexion, $query);
            $array = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            $rol = $array['id_Rol'];
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); #Cerramos la conexión.
        return $rol;
    }

    public static function editarRol($nuevoRol){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevoRol->id_Rol;
            $descripcion=$nuevoRol->descripcion;
            $modificadoPor=$nuevoRol->ModificadoPor;
            date_default_timezone_set('America/Tegucigalpa'); 
            $fechaModificado = date("Y-m-d h:i:s");
            $update = "UPDATE tbl_ms_roles SET descripcion='$descripcion', Modificado_Por='$modificadoPor', Fecha_Modificacion='$fechaModificado' WHERE id_Rol='$id' ";
            sqlsrv_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); #Cerramos la conexión.
    }

    public static function rolExistente($rol){
        $existeRol = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT rol FROM tbl_MS_Roles WHERE rol = '$rol'";
        $roles = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($roles);
        if($existe){
            $existeRol = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existeRol;
    }

    public static function eliminarRol($rol){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_MS_Roles WHERE id_Rol = '$rol';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }

    public static function obtenerRolesUsuarioPDF($buscar){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT id_Rol, rol, descripcion FROM tbl_ms_roles
        WHERE CONCAT(id_Rol, rol, descripcion) LIKE '%' + '$buscar' + '%';";
        $obtenerRoles = sqlsrv_query($consulta, $query);
        $roles = array();
        while($fila = sqlsrv_fetch_array($obtenerRoles, SQLSRV_FETCH_ASSOC)){
            $roles [] = [
                'id_Rol' => $fila["id_Rol"],
                'rol' => $fila["rol"],
                'descripcion' => $fila["descripcion"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $roles;
    }

}
