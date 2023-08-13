<?php

class ControladorRol {

    public static function rol($id_Rol){
        $valido = false;
        $id_Rol = Rol::existeRol($id_Rol);
        if($id_Rol > 0){
            $valido = true;
        }
        return $valido;
    }
    public static function rolesUsuario(){
        return Rol::obtenerRolesUsuario();
    }
    public static function ingresarNuevoRol($nuevoRol){
        return Rol::registroRol($nuevoRol);
    }
    public static function eliminarRol($id_Rol){
        return Rol::eliminarRol($id_Rol);
    }
    public static function editarRolUsuario($nuevoRol){
       return Rol::editarRol($nuevoRol);
    }

}