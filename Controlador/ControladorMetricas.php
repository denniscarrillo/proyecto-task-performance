<?php
    class ControladorMetricas {
        
        public static function obtenerMetricas(){
            return Metricas::obtenerTodasLasMetricas();
        }

        public static function editarMetricas($nuevaMetrica){
            return Metricas::editarMetrica($nuevaMetrica);
        }
    }