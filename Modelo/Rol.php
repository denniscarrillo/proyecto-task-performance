<?php

class Rol {
    public $id_Rol;
    public $rol;
    public $descripcion;

    public static function obtenerRolesUsuario(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $obtenerRoles = $consulta->query("SELECT id_Rol, rol, descripcion FROM tbl_ms_roles");
        $roles = array();
        while($fila = $obtenerRoles->fetch_assoc()){
            $roles [] = [
                'id_Rol' => $fila["id_Rol"],
                'rol' => $fila["rol"],
                'descripcion' => $fila["descripcion"]
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $roles;
    }

    public static function registroRol($nuevoRol) {
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $rol=$nuevoRol->rol;
            $descripcion=$nuevoRol->descripcion;
            $insert = "INSERT INTO tbl_ms_roles (rol, descripcion) VALUES ('$rol','$descripcion');";
            $ejecutar_insert = mysqli_query($abrirConexion, $insert);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }

    public static function eliminarRol($id_Rol){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $rol=$nuevoRol->rol;
            $descripcion=$nuevoRol->descripcion;
            $insert = "INSERT INTO tbl_ms_roles (rol, descripcion) VALUES ('$rol','$descripcion');";
            $ejecutar_insert = mysqli_query($abrirConexion, $insert);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }

    public static function editarRol($nuevoRol){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevoRol->id_Rol;
            $rol=$nuevoRol->rol;
            $descripcion=$nuevoRol->descripcion;
            $update = "UPDATE tbl_ms_roles SET rol='$rol', descripcion='$descripcion' WHERE id_Rol='$id' ";
            $ejecutar_update = mysqli_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }

}
