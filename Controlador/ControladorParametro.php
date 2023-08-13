<?php

class ControladorParametro {
    public static function obtenerParametroSistema(){
        return Parametro::obtenerTodosLosParametros();
    }
}