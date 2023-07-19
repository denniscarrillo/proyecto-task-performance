<?php
    class ControladorCarteraClientes {
        
        public static function obtenerCarteraClientes(){
            return CarteraClientes::obtenerCarteraClientes();
        }

        public static function registroCliente($nuevoCliente){
            return CarteraClientes::registroNuevoCliente($nuevoCliente);
        }
    }

    