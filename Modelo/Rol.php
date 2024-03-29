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
        $query = "SELECT ROW_NUMBER() OVER(ORDER BY id_Rol ASC) AS Num, id_Rol, rol, descripcion FROM tbl_ms_roles";
        $obtenerRoles = sqlsrv_query($consulta, $query);
        $roles = array();
        while($fila = sqlsrv_fetch_array($obtenerRoles, SQLSRV_FETCH_ASSOC)){
            $roles [] = [
                'item' => $fila["Num"],
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
            $modificadoPor=$nuevoRol->ModificadoPor;
            $insert = "INSERT INTO tbl_ms_roles (rol, descripcion, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) VALUES ('$rol','$descripcion', '$creadoPor', GETDATE(), '$modificadoPor', GETDATE())";
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
            $update = "UPDATE tbl_ms_roles SET descripcion='$descripcion', Modificado_Por='$modificadoPor', GETDATE() WHERE id_Rol='$id' ";
            sqlsrv_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); #Cerramos la conexión.
    }

    public static function rolExistente($rol){
        $estado = false;
        try{
            $existente = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT rol FROM tbl_MS_Roles WHERE rol = '$rol'";
            $consulta = sqlsrv_query($abrirConexion, $selectCliente);
            if(sqlsrv_has_rows($consulta)){
                while($fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
                    $existente = [
                        'rol' => $fila['rol']
                    ];
                }
                sqlsrv_close($abrirConexion); //Cerrar conexion
                return $existente;
            } else {
               return $estado;
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
    }

    public static function eliminarRol($rol){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_MS_Roles WHERE id_Rol = '$rol';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
            if(!$estadoEliminado) {
                return false;
            }
            sqlsrv_close($conexion); //Cerrar conexion
            return true;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
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
