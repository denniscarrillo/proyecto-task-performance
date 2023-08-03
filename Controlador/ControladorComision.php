<?php
    class ControladorComision {
        
        public static function getComision(){
            return Comision::obtenerTodasLasComisiones();
        }
        public static function registroComision($nuevaComision){
            return Comision::registroNuevaComision($nuevaComision);
        }
        public static function traerPorcentajesComision(){
            return Comision::obtenerPorcentajesComision();
        }
        public static function traerVendedores($idTarea) {
            return Comision::obtenerVendedores($idTarea);
        }
        public static function traerIdTarea($idTarea){
            return Comision::obtenerIdTarea($idTarea);
        }
        public static function calcularComisionTotal($porcentaje, $totalVenta){
            return Comision::calcularComision($porcentaje, $totalVenta);
        }
    }