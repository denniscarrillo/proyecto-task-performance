<?php

class Rol {

    public static function obtenerRolesUsuario(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $obtenerRoles = $conexion->query("SELECT id_Rol, rol FROM tbl_ms_roles;");
        $roles = array();
        while($fila = $obtenerRoles->fetch_assoc()){
            $roles [] = [
                'id_Rol' => $fila["id_Rol"],
                'rol' => $fila["rol"]
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $roles;
    }





















}
