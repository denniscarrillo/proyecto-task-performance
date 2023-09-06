<?php

class ControladorDataTableTarea {

  
    public static function DataTableTarea($User){
        return DataTableTarea::obtenerTareas($User);
    }
}