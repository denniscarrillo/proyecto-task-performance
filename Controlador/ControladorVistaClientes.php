<?php
    class ControladorVistaClientes {
        
        public static function getClientes(){
            return Cliente::obtenerTodosLosClientes();
        }
        public static function getClientesPdf($buscar){
            return Cliente::obtenerTodosLosClientesPdf($buscar);
        }
    }

    