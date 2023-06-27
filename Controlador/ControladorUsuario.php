<?php
    class ControladorUsuario {
        
        public static function getUsuarios(){
            // require_once('Modelo/Usuario.php');
            $Usuarios = Usuario::obtenerTodosLosUsuarios();
            return $Usuarios; 
        }
        public static function login($usuario, $contrasenia){
            $valido = false;
            $usuario = Usuario::existeUsuario($usuario, $contrasenia);
            if($usuario > 0){
                $valido = true;
            }
            return $valido;
        }
        public function registroUsuario($nuevoUsuario){
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
    }