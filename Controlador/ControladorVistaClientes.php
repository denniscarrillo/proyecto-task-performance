<?php
    class ControladorVistaClientes {
        
        public static function getClientes(){
            return Cliente::obtenerTodosLosClientes();
        }
    }

    