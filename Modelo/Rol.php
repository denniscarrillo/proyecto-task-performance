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
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); // Abrimos la conexión a la DB.
    
        $rol = mysqli_real_escape_string($consulta, $nuevoRol->rol); // Escapamos los valores para prevenir inyección SQL.
        $descripcion = mysqli_real_escape_string($consulta, $nuevoRol->descripcion);
    
        // Usamos una sentencia preparada para evitar inyección SQL.
        $query = "INSERT INTO 'tbl_ms_roles' ('rol', 'descripcion') VALUES ('$rol', '$descripcion')";
        $stmt = $consulta->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param($rol, $descripcion); // Asociamos los parámetros a la sentencia.
            $stmt->execute(); // Ejecutamos la sentencia.
            $stmt->close(); // Cerramos la sentencia preparada.
        } else {
            // Manejo de error en caso de fallo en la preparación de la sentencia.
            throw new Exception("Error al preparar la consulta.");
        }
    
        $conn->close(); // Cerramos la conexión.
    
        return true; // Devolvemos `true` para indicar éxito en la inserción.
    }

    public static function eliminarRol($id_Rol){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        //Eliminamos el usuario
        $estadoEliminado = $conexion->query("DELETE FROM tbl_ms_roles WHERE id_Rol = $id_Rol;");
        mysqli_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }

    public static function editarRol($nuevoRol){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idRol = $nuevoRol->idRol;
        $rol =$nuevoRol->rol;
        $descripcion =$nuevoRol->descripcion;
        $nuevoRol = $conexion->query("UPDATE tbl_ms_roles SET rol='$rol', descripcion='$descripcion' WHERE id_Rol='$idRol' ");
        mysqli_close($conexion); #Cerramos la conexión.
    }

}
