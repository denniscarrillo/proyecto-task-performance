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
}