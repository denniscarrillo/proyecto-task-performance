<?php
    class ControladorComision {
        
        public static function getComision(){
            return Usuario::obtenerTodasLasComision();
        }

    }