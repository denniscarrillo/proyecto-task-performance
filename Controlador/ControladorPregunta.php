<?php

class ControladorPregunta {
    public static function preguntasUsuario(){
        return Pregunta::obtenerPreguntasUsuario();
    }
}