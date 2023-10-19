<?php
    class ControladorVenta{
        public static function getVentas(){
            return Venta::obtenertodaslasventas();
        }
        public static function traerVentasPorFechas($fechaDesde, $fechaHasta){
            return Venta::obtenerVentasPorFechas($fechaDesde, $fechaHasta);
        }
        public static function obtenerIdVentas($numFactura){
            return Venta::obtenerIdVenta($numFactura);
        }
    }