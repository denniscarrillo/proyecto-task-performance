<?php
    class ControladorSolicitud {
        
        public static function getSolicitudes(){
            return Solicitud::obtenerTodasLasSolicitudes();
        }

    }
    