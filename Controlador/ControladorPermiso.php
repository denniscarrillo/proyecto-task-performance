<?php

class ControladorPermiso {
    public static function obtenerPermisosSistema(){
        return Permiso::obtenerPermisos();
    }
    public static function obtenerObjetosPermiso(){
        return Permiso::obtenerObjetos();
    }
    public static function registroNuevoPermiso($nuevoPermiso){
        Permiso::registroPermiso($nuevoPermiso);
    }
}