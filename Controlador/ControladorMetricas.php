<?php
    class ControladorMetricas {
        
        public static function obtenerMetricas(){
            return Metricas::obtenerMetricas();
        }

    //     public static function registroCliente($nuevoCliente){
    //         return CarteraClientes::registroNuevoCliente($nuevoCliente);
    //     }

    //     public static function estadoContactoCliente(){
    //         return CarteraClientes::obtenerContactoCliente();
    //     }

    //     public static function editarCliente($nuevoCliente){
    //         CarteraClientes::editarCliente($nuevoCliente);
    //     }

    //     public static function eliminarCliente($nombre){
    //       return CarteraClientes::eliminarCliente($nombre);
    //    }
    }