<?php

class ControladorParametro {
    public static function obtenerParametroSistema(){
        return Parametro::obtenerTodosLosParametros();
    }
    public static function editarParametroSistema($nuevoPorcentaje){
        return Parametro::editarParametros($nuevoPorcentaje);
    }

    public static function obtenerVigencia(){
        return Parametro::obtenerVigencia();
    }
    public static function getDataServerEmail(){
        return Parametro::dataServerEmail();
    }
    public static function obtenerVigenciaToken(){
        return Parametro::obtenerVigenciaToken();
    }

    public static function obtenerDatosReporte(){
        return Parametro::obtenerDatosReporte();
    }
    public static function eliminandoParametro($parametro){
        return Parametro::eliminarParametro($parametro);
    }
    public static function obtenerLosParametrosPDF($buscar){
        return Parametro::obtenerLosParametrosPDF($buscar);
    }
    
    public static function obtenerVigenciaLiquidar(){
        return Parametro::obtenerVigenciaLiquidacion();
    }

    public static function obtenerCorreoDestino(){
        return Parametro::obtenerCorreoDestino();
    }
    
}