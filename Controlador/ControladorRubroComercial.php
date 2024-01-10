<?php

class ControladorRubroComercial {

    public static function getRubroComercial() {
        return RubroComercial::obtenerTodosLosRubrosComerciales();
    }

    public static function crearRubroComercial($nuevoRubroComercial) {
        RubroComercial::nuevoRubroComercial($nuevoRubroComercial);
    }

    public static function editarRubroComercial($nuevoRubroComercial) {
        RubroComercial::editarRubroComercial($nuevoRubroComercial);
    }

    public static function eliminarRubroComercial($idRubroComercial) {
        return RubroComercial::eliminarRubroComercial($idRubroComercial);
    }

    public static function RubroComercialExiste($rubroComercial) {
        return RubroComercial::RubroComercialExistente($rubroComercial);
    }

    public static function obtenerRubroComercialPDF($buscar) {
        return RubroComercial::obtenerPdfRubroComercial($buscar);
    }

}