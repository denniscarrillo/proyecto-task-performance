<?php

class ControladorDataTableTarea {

  
    public static function DataTableTarea($User){
        return DataTableTarea::obtenerTareas($User);
    }

    public static function obtenerTareasPDF($User, $buscar){
        return DataTableTarea::obtenerTareasPDF($User, $buscar);
    }
}