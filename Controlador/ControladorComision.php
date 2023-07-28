<?php
    class ControladorComision {
        
        public static function getComision(){
            return Comision::obtenerTodasLasComisiones();
        }
        public static function registroComision(){
            return Comision::registroNuevaComision();
        }
        public static function traerPorcentajesComision(){
            return Comision::obtenerPorcentajesComision();
        }


    }