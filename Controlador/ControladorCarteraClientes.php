<?php
    class ControladorCarteraClientes {
        
        public static function obtenerCarteraClientes(){
            return CarteraClientes::obtenerCarteraClientes();
        }

        public static function registroCliente($nuevoCliente){
            return CarteraClientes::registroNuevoCliente($nuevoCliente);
        }

        public static function editarCliente($nuevoCliente){
            CarteraClientes::editarCliente($nuevoCliente);
        }

        public static function rtnExiste($rtn){
            return CarteraClientes::rtnExistente($rtn);
        }

        public static function eliminarCliente($CarteraCliente){
            return CarteraClientes::eliminarCliente($CarteraCliente);
        }
    
    }

    