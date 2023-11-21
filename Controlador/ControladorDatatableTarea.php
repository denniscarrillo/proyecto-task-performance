<?php

class ControladorDataTableTarea {

  
    public static function obtenerTareasUsuario($usuario){
        return DataTableTarea::obtenerTodasTareasUsuario($usuario);
    }

    public static function obtenerTareasPDF($User, $buscar){
        return DataTableTarea::obtenerTareasPDF($User, $buscar);
    }
}