<?php
    class ControladorPorcentajes {
    
        public static function getPorcentaje(){
            return Porcentajes::obtenerPorcentajes();
        }

        public static function registroNuevoPorcentaje($nuevoPorcentaje){
            return Porcentajes::registroNuevoPorcentaje($nuevoPorcentaje);
        }

        public static function editarPorcentaje($nuevoPorcentaje){
            Porcentajes::editarPorcentaje($nuevoPorcentaje);
        }

        
    }
