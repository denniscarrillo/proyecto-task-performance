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


    public static function actualizarRespuesta($respuestas,$user){
        Pregunta::actualizarRespuesta($respuestas,$user);
    }  

    public static function eliminarPregunta($pregunta){
         return Pregunta::eliminarPregunta($pregunta);
    }
    // public static function verificarPreguntaActiva($idPregunta){
    //     return Pregunta::verificarPreguntaActiva($idPregunta);
    // }
    public static function obtenerPreguntasUsuarioPDF($buscar){
    return Pregunta::obtenerPreguntasUsuarioPDF($buscar);
    }
    public static function validarPreguntaExistente($pregunta){
        return Pregunta::validarPreguntaExistente($pregunta);
    }
       
}