<?php

class ControladorDataTableSolicitud {

  
    public static function DataTableSolicitud($User){
        return DataTableSolicitud::obtenerSolicitud($User);
    }

    public static function actualizarEstadoSolicitud($nuevaSolicitud){
        return DataTableSolicitud::actualizarEstadoSolicitud($nuevaSolicitud);
    }

    
}