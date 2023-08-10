<?php
    class ControladorPorcentajes {
    
        public static function getPorcentaje(){
            return Porcentajes::obtenerPorcentajes();
        }

        public static function registroNuevoPorcentaje($nuevoPorcentaje){
            return Porcentajes::registroNuevoPorcentaje($nuevoPorcentaje);
        }

        // public static function estadoContactoCliente(){
        //     return CarteraClientes::obtenerContactoCliente();
        // }

        // public static function editarCliente($nuevoCliente){
        //     CarteraClientes::editarCliente($nuevoCliente);
        // }

        
    }
