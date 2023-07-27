<?php
    class ControladorSolicitud {
        
        public static function getSolicitudes(){
            return Solicitud::obtenerTodasLasSolicitudes();
        }

        public static function crearSolicitud($nuevaSolicitud){
            return Solicitud::crearNuevaSolicitud($nuevaSolicitud);
        }

        
        public static function obtenerTipoSolicitud(){
            return Solicitud::obtenerTipoServicio();
        }

        public static function obtenerEstadoSolicitud(){
            return Solicitud::obtenerEstadoSolicitud();
        }
    }
    

   
    

    