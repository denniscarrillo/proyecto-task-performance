<?php
    class ControladorVentas{
        
        public static function getVentas(){
            return Venta::obtenertodaslasventas();
        }
    }