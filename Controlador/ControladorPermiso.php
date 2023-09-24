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
}