<?php
    class ControladorUsuario {
        
        public static function getUsuarios(){
            return Usuario::obtenerTodosLosUsuarios();
        }
        public static function login($usuario, $contrasenia){
           return Usuario::existeUsuario($usuario, $contrasenia);
        }
        public static function registroUsuario($nuevoUsuario){
            return Usuario::registroNuevoUsuario($nuevoUsuario);
        }
        public static function intentosLogin(){
            return Usuario::intentosPermitidos();
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
        public static function obtenerPreguntasUsuario(){
            return Usuario::obtenerPreguntasUsuario();
        }
        public static function guardarRespuestas($usuario, $idPreguntas, $respuestas){
            Usuario::guardarRespuestasUsuario($usuario, $idPreguntas, $respuestas);
        }
        public static function obtenerEstadoUsuario(){
            return Usuario::obEstadoUsuario();
        }
        public static function eliminarUsuario($usuario){
            return Usuario::eliminarUsuario($usuario);
        }
        public static function editarUsuario($nuevoUsuario){
            Usuario::editarUsuario($nuevoUsuario);
        }
        public static function obRolUsuario($usuario){
            return Usuario::obtenerRolUsuario($usuario);
        }
        public static function getPreguntas($usuario){
            return Usuario::obtenerPreguntas($usuario); 
        }
        public static function existeUsuario($userName){
            return Usuario::validarUsuario($userName); 
        }
        public static function obtenerRespuesta($idPregunta){
            return Usuario::obtenerRespuestaPregunta($idPregunta); 
        }
        public static function obCorreoUsuario($usuario){
            return Usuario::correoUsuario($usuario);
        } 
        public static function almacenarToken($user, $token){
            return Usuario::guardarToken($user, $token);
        }
        public static function usuarioExiste($usuario){
            return Usuario::usuarioExistente($usuario);
        }
        public static function cantPreguntasContestadas($usuario){
            return Usuario::obtenerCantPreguntasContestadas($usuario);
        }
        public static function incrementarPregContestadas($usuario,$cantActual){
            Usuario::incrementarPreguntasContestadas($usuario, $cantActual);
        }
        public static function cambiarEstado($usuario){
            Usuario::cambiarEstadoNuevo($usuario);
        } 
        public static function respaldarContrasenia($usuario){
            return Usuario::respaldarContraseniaAnterior($usuario);
        } 
        public static function actualizarContrasenia($usuario, $contrasenia){
            return Usuario::actualizaRContrasenia($usuario, $contrasenia);
        }    
        public static function origenNuevoUsuario($usuario){
            return Usuario::origenNuevoUsuario($usuario);
        }   
        public static function validarTokenUsuario($usuario, $tokenUsuario){
            return Usuario::validarToken($usuario, $tokenUsuario);
        }
        public static function obtenerIdUsuario($usuario){
            return Usuario::obtenerIdUsuario($usuario);
        }
        public static function permisosRol($idRol){
            return Usuario::permisosRol($idRol);
        }
        public static function permisoSobreObjeto($userName, $IdObjetoActual, $permisosRol) {
            return Usuario::validarPermisoSobreObjeto($userName, $IdObjetoActual, $permisosRol);
        }
        public static function validarUsuarioExistente($usuario){
            return Usuario::usuarioExiste($usuario);
        }
    }