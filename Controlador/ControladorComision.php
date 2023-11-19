<?php
    class ControladorComision {
        
        public static function getComision(){
            return Comision::obtenerTodasLasComisiones();
        }
        public static function registroComision($nuevaComision){
            return Comision::registroNuevaComision($nuevaComision);
        }
        public static function traerPorcentajesComision(){
            return Comision::obtenerPorcentajesComision();
        }
        public static function traerVendedores($idTarea) {
            return Comision::obtenerVendedores($idTarea);
        }
        public static function traerIdTarea($idTarea){
            return Comision::obtenerIdTarea($idTarea);
        }
        public static function calcularComisionTotal($porcentaje, $totalVenta){
            return Comision::calcularComision($porcentaje, $totalVenta);
        }
        public static function guardarComisionVendedor($comision, $idComision, $vendedores, $user, $fechaComision, $fechaLiquidacion){
            Comision::dividirComisionVendedores($comision, $idComision, $vendedores, $user, $fechaComision, $fechaLiquidacion);
        }
        public static function actualizarComision($nuevaComision){
            Comision::editarComision($nuevaComision);
        }
        public static function traerComisionesPorVendedor(){
            return Comision::obtenerComisionesPorVendedor();
        }
        public static function obtenerSumaComisionesVendedores($fechaDesde, $fechaHasta){
            return Comision::sumarComisionesVendedor($fechaDesde, $fechaHasta);
        }
        public static function obtenerFechasComisiones($fechaDesde, $fechaHasta){
            return Comision::fechasComisiones($fechaDesde, $fechaHasta);
        }
        public static function traerEstadoComision($idVenta){
            return Comision::obtenerEstadoComision($idVenta);
        } 
        public static function editarEstadoComisionVendedor($comision){
            return Comision::actualizarEstadoComisionVendedor($comision);
        }

        public static function traerIdComision($idComision){
            return Comision::ComisionPorId($idComision);
        }
       
        public static function SimularAnularComision($idComision){
            return Comision::anularComision($idComision);
        }
        public static function SimularAnularComisionVendedor($idComision){
            return Comision::anularComisionPorVendedor($idComision);
        }

        public static function eliminandoComision($idComision){
            return Comision::eliminarComision($idComision);
        }
        public static function getComisionesPdf($buscar){
            return Comision::obtenerTodasLasComisionesPdf($buscar);
        }
        public static function getComisionesVendedorPdf($buscar){
            return Comision::obtenerComisionesPorVendedorPdf($buscar);
        }
        public static function liquidandoComisiones($fechaDesde, $fechaHasta){
            return Comision::liquidarComisiones($fechaDesde, $fechaHasta);
        }
    }