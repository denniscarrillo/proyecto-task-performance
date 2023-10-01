<?php

class ControladorPermiso {
    public static function obtenerPermisosSistema(){
        return Permiso::obtenerPermisos();
    }
    public static function obtenerObjetosPermiso(){
        return Permiso::obtenerObjetos();
    }
    public static function registroNuevoPermiso($idRol, $idObjetos, $creadoPor){
        Permiso::registroPermiso($idRol, $idObjetos, $creadoPor);
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
}