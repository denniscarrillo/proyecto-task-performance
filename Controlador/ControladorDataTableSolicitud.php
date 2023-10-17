<?php

class ControladorDataTableSolicitud {

  
    public static function DataTableSolicitud($User){
        return DataTableSolicitud::obtenerSolicitud($User);
    }

    public static function actualizarEstadoSolicitud($nuevaSolicitud){
        return DataTableSolicitud::actualizarEstadoSolicitud($nuevaSolicitud);
    }

    public static function LlenarModalSolicitudEditar($idSolicitud){
        return DataTableSolicitud::obtenerSolicitudPorId($idSolicitud);
    }

    public static function editarDataTableSolicitud($EditarSolicitud){
        return DataTableSolicitud::editarSolicitud($EditarSolicitud);
    }

    public static function VerSolicitudesPorId($idSolicitud){
        return DataTableSolicitud::VerSolicitudesPorId($idSolicitud);
    }

    
}