<?php
    class ControladorVenta{
        public static function getVentas(){
            return Venta::obtenertodaslasventas();
        }
        public static function crearNuevaVenta($nuevaVenta){
            Venta::crearNuevaVenta($nuevaVenta);
        }
        public static function validarClienteExistenteCarteraCliente($rtn){
            return Venta::validarClienteExistenteCarteraCliente($rtn);
        }
        public static function eliminarVenta($numFactura){
            return Venta::eliminarVenta($numFactura);
        }
        public static function traerVentasPorFechas($fechaDesde, $fechaHasta){
            return Venta::obtenerVentasPorFechas($fechaDesde, $fechaHasta);
        }
        public static function obtenerIdVentas($numFactura){
            return Venta::obtenerIdVenta($numFactura);
        }
        public static function obtenerlasventasPDF($buscar){
            return Venta::obtenerlasventasPDF($buscar);
        }
        
    }