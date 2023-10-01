<?php

class ControladorPregunta {
    public static function preguntasUsuario(){
        return Pregunta::obtenerPreguntasUsuario();
    }
    public static function agregarPregunta($insertarPregunta){
        return Pregunta::insertarPregunta($insertarPregunta);
    }

    public static function actualizarPregunta($insertarPregunta){
        return Pregunta::editarPregunta($insertarPregunta);
    }

    public static function eliminandoPregunta($pregunta){
        return Pregunta::eliminarPregunta($pregunta);
    }
    public static function preguntaExiste($pregunta){
        return Pregunta::preguntaExistente($pregunta);
    }
}