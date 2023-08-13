<?php

class ControladorPermiso {
    public static function obtenerPermisosSistema(){
        return Permiso::obtenerPermisos();
    }
}