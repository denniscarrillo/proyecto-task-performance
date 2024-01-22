<?php
    class ControladorMetricas {
        
        public static function obtenerMetricas(){
            return Metricas::obtenerTodasLasMetricas();
        }

        public static function editarMetricas($nuevaMetrica){
            return Metricas::editarMetrica($nuevaMetrica);
        }

        public static function obtenerNombreMetrica($idMetrica){
            return Metricas::obtenerEstadoAvance($idMetrica);
        }

        public static function obtenerMetaMetricas(){
            return Metricas::obtenerMetas();
        }
        public static function eliminarMetrica($metrica){
            return Metricas::eliminarMetrica($metrica);
        }

        public static function obtenerLasMetricasPDF($buscar){
            return Metricas::obtenerLasMetricasPDF($buscar);
        }

        public static function obtenerEstadisticas(){
            return Metricas::obtenerEstadisticas();
        }

        public static function obtenerEstadisticasGeneral($FechaInicial, $FechaFinal){
            return Metricas::obtenerEstadisticasGeneral($FechaInicial, $FechaFinal);
        }

        public static function obtenerEstadisticasPorVed($idUsuario, $FechaInicial, $FechaFinal){
            return Metricas::obtenerEstadisticasPorVed($idUsuario, $FechaInicial, $FechaFinal);
        }
    }