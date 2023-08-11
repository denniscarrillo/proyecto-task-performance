<?php
    class ControladorMetricas {
        
        public static function obtenerMetricas(){
            return Metricas::obtenerMetricas();
        }

        public static function registroNuevaMetrica($nuevaMetrica){
            return Metricas::registroNuevaMetrica($nuevaMetrica);
        }

        public static function EstadoAvance(){
            return Metricas::obtenerEstadoAvance();
        }

        public static function editarMetrica($nuevaMetrica){
            Metricas::editarMetrica($nuevaMetrica);
        }

        public static function eliminarMetrica($idMetrica){
          return Metricas::eliminarMetrica($idMetrica);
       }
    }