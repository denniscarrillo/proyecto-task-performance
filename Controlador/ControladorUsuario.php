<?php
    class ControladorUsuario {
        
        public static function getUsuarios(){
            return Usuario::obtenerTodosLosUsuarios();
        }
        public static function login($usuario, $contrasenia){
            $valido = false;
            $usuario = Usuario::existeUsuario($usuario, $contrasenia);
            if($usuario > 0){
                $valido = true;
            }
            return $valido;
        }
        public static function registroUsuario($nuevoUsuario){
            return Usuario::registroNuevoUsuario($nuevoUsuario);
        }
        public static function intentosLogin(){
            return  Usuario::intentosPermitidos();
        }
        public static function bloquearUsuario($max, $intentos, $user){
            return Usuario::bloquearUsuario($max, $intentos, $user);
        }
        public static function intentosFallidos($usuario){
            return Usuario::intentosInvalidos($usuario);
        }
        public static function incrementarIntentos($usuario, $intentosFallidos){
            return Usuario::aumentarIntentosFallidos($usuario, $intentosFallidos);
        }
        public static function cantidadPreguntas(){
            return Usuario::parametroPreguntas();
        }
        public static function resetearIntentos($usuario) {
            Usuario::resetearIntentosFallidos($usuario);
        }
        public static function estadoUsuario ($usuario){
            return Usuario::obtenerEstadoUsuario($usuario);
        }
        public static function almacenarPreguntas ($preguntas, $usuario){
            Usuario::guardarPreguntas($preguntas, $usuario);
        }

        public static function obtenerPreguntasUsuario($usuario){
            return Usuario::obtenerPreguntasUsuario($usuario);
        }
        public static function guardarRespuestas($usuario, $idPreguntas, $respuestas){
            Usuario::guardarRespuestasUsuario($usuario, $idPreguntas, $respuestas);
        }
        public static function obtenerEstadoUsuario(){
            return Usuario::obEstadoUsuario();
        }
        public static function eliminarUsuario($usuario){
            Usuario::eliminarUsuario($usuario);
        }
        public static function editarUsuario($nuevoUsuario){
            Usuario::editarUsuario($nuevoUsuario);
        }
        public static function obRolUsuario($usuario){
            return Usuario::obtenerRolUsuario($usuario);
        }
        public static function getPreguntas($usuario){
            $Preguntas = Usuario::obtenerPreguntas($usuario);
            return $Preguntas; 
        }
        public static function existeUsuario($userName){
            return Usuario::validarUsuario($userName); 
        }
        public static function obtenerRespuesta($idPregunta){
            return Usuario::obtenerRespuestaPregunta($idPregunta); 
        }
        
    }