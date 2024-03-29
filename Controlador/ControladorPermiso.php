<?php

class ControladorPermiso {
    public static function obtenerPermisosSistema(){
        return Permiso::obtenerPermisos();
    }
    public static function obtenerObjetosPermiso(){
        return Permiso::obtenerObjetos();
    }
    public static function registroNuevoPermiso($idRol, $idObjetos, $user){
        Permiso::registroPermiso($idRol, $idObjetos, $user);
    }
    public static function obtenerIdRolObjeto($rol, $objeto){
        return Permiso::obtenerIdRolObjeto($rol, $objeto);
    }
    public static function actualizarPermisosRol($permisos){
        Permiso::actualizarPermisos($permisos);
    }
    public static function obtenerPermisosUsuario($usuario) {
        return Permiso::obtenerPermisosUsuario($usuario);
    }
    public static function obtenerPermisosUsuarioObjeto($usuario, $idObjeto){
        return Permiso::obtenerPermisosObjeto($usuario, $idObjeto);
    }
    public static function obtenerPermisosPDF($buscar){
        return Permiso::obtenerPermisosPDF($buscar);
    }
}