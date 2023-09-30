<?php
    class ControladorSolicitud {
        
        public static function getSolicitudes(){
            return Solicitud::obtenerTodasLasSolicitudes();
        }

        public static function crearSolicitud($nuevaSolicitud){
            Solicitud::crearNuevaSolicitud($nuevaSolicitud);
        }

        
        public static function obtenerTipoSolicitud(){
            return Solicitud::obtenerTipoServicio();
        }

        public static function obtenerEstadoSolicitud(){
            return Solicitud::obtenerEstadoSolicitud();
        }

        public static function obtenerIdUsuario(){
            return Usuario::obtenerIdUsuario();
        }

        public static function obtenerCliente(){
            return Solicitud::obtenerCliente();
        }

        public static function editarSolicitud($editarSolicitud){
            Solicitud::editarSolicitud($editarSolicitud);
        }

        public static function eliminarSolicitud($solicitud){
            return Solicitud::eliminarSolicitud($solicitud);
        }

        public static function servicioTecnicoExiste($servicio){
            return Solicitud::servicioTecnicoExistente($servicio);
        }

    }
    

   
    

    