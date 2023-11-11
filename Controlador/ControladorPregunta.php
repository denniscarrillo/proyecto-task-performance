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

    
    public static function preguntaExiste($pregunta){
        return Pregunta::preguntaExistente($pregunta);
    }

    public static function obtenerCantPreguntas(){
        return Pregunta::obtenerCantPreguntas();
    }

    public static function obtenerPreguntasXusuario($Usuario){
        return Pregunta::obtenerPreguntasXusuario($Usuario);
    }
    public static function actualizarRespuesta($idUsuario, $respuestas){
        Pregunta::actualizarRespuesta($idUsuario, $respuestas);
    }
    public static function eliminandoPregunta($pregunta){
        return Pregunta::eliminarPregunta($pregunta);
    }
    public static function SimularInactivarPregunta($pregunta){
        return Pregunta::inactivarPregunta($pregunta);
    }
    
}