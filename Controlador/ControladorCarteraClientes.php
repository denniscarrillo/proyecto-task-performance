<?php
    class ControladorCarteraClientes {
        
        public static function obtenerCarteraClientes(){
            return CarteraClientes::obtenerCarteraClientes();
        }

        public static function registroCliente($nuevoCliente){
            return CarteraClientes::registroNuevoCliente($nuevoCliente);
        }

        public static function estadoContactoCliente(){
            return CarteraClientes::obtenerContactoCliente();
        }

        //public static function eliminarCliente($nombre){
         //   return CarteraClientes::eliminarCliente($nombre);
       // }
    }

    