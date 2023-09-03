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
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); #Cerramos la conexión.
    }

    public static function editarRol($nuevoRol){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevoRol->id_Rol;
            $rol=$nuevoRol->rol;
            $descripcion=$nuevoRol->descripcion;
            $modificadoPor=$nuevoRol->ModificadoPor;
            date_default_timezone_set('America/Tegucigalpa'); 
            $fechaModificado = date("Y-m-d h:i:s");
            $update = "UPDATE tbl_ms_roles SET rol='$rol', descripcion='$descripcion', Modificado_Por='$modificadoPor', Fecha_Modificacion='$fechaModificado' WHERE id_Rol='$id' ";
            $ejecutar_update = sqlsrv_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); #Cerramos la conexión.
    }

}
