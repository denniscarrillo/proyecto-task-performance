<?php
    class ControladorComision {
        
        public static function getComision(){
            return Comision::obtenerTodasLasComisiones();
        }

    }