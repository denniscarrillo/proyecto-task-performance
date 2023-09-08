<?php

class ControladorDataTableSolicitud {

  
    public static function DataTableSolicitud($User){
        return DataTableSolicitud::obtenerSolicitud($User);
    }
}