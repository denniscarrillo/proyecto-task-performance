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

    //     public static function editarCliente($nuevoCliente){
    //         CarteraClientes::editarCliente($nuevoCliente);
    //     }

    //     public static function eliminarCliente($nombre){
    //       return CarteraClientes::eliminarCliente($nombre);
    //    }
    }