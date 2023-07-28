<?php
    class ControladorVenta{
        public static function getVentas(){
            return Venta::obtenertodaslasventas();
        }
        public static function traerVentasPorFechas($fechaDesde, $fechaHasta){
            return Venta::obtenerVentasPorFechas($fechaDesde, $fechaHasta);
        }
    }