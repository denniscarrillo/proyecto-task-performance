<?php

class ControladorDataTableTarea {

  
    public static function obtenerTareasUsuario($usuario, $rolUsuario){
        return DataTableTarea::obtenerTodasTareasUsuario($usuario, $rolUsuario);
    }

    public static function obtenerTareasPDF($User, $buscar){
        return DataTableTarea::obtenerTareasPDF($User, $buscar);
    }

    public static function obtenerTareasId($idTarea){
        return DataTableTarea::obtenerTareasId($idTarea);
    }
}