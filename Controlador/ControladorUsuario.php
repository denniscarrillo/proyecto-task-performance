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
        public static function validarPreguntasUsuario($idPregunta, $usuario){
            return Usuario::validarPreguntasUsuario($idPregunta, $usuario);
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
        public static function intentosFallidosRespuesta(){
            return Usuario::intentosFallidosRespuesta();
        }
        public static function obtenerIntentosRespuestas($usuario){
            return Usuario::obtenerIntentosRespuestas($usuario);
        }
        public static function reiniciarIntentosFallidosRespuesta($usuario){
            Usuario::reiniciarIntentosRespuesta($usuario);
        }
        public static function aumentarIntentosFallidosRespuesta($usuario, $intentosFallidos){
            return Usuario::aumentarIntentosFallidosRespuesta($usuario, $intentosFallidos);
        }
        public static function obtenerRespuesta($idPregunta, $usuario){
            return Usuario::obtenerRespuestaPregunta($idPregunta, $usuario); 
        }
        public static function bloquearUsuarioMetodoPregunta($usuario){
            Usuario::bloquearUsuarioMetodoPregunta($usuario);
        }
        public static function obCorreoUsuario($usuario){
            return Usuario::correoUsuario($usuario);
        } 
        public static function almacenarToken($user, $creadoPor){
            return Usuario::guardarToken($user, $creadoPor);
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
        public static function respaldarContrasenia($userCreador, $usuario, $contraseniaActual, $origenLlamadaFuncion){
             Usuario::respaldarContraseniaActual($userCreador, $usuario, $contraseniaActual, $origenLlamadaFuncion);
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
        public static function obtenerCantVendedores(){
            return Usuario::CantVendedores();
        }

        public static function traerVendedores() {
            return Usuario::obtenerVendedores();
        }

        public static function editarPerfilUsuario($nuevoUsuario){
            Usuario::editarPerfilUsuario($nuevoUsuario);
        }

        public static function obtenerDatosPerfilUsuario($userName){
           return Usuario::obtenerDatosPerfilUsuario($userName);
        }
        
        public static function obtenerUsuariosPorId($IdUsuario) {
            return Usuario::obtenerUsuariosPorId($IdUsuario);
        }
        public static function parametrosLimiteContrasenia(){
            return Usuario::parametrosContrasenia();
        }

        public static function eliminarUltimaContrasena($idUsuario) {
            return Usuario::eliminarContrasena($idUsuario);
        }

        public static function obtenerIdUsuariosPassword() {
            return Usuario::obtenerIdUsuariosPassword();
        }
        
        public static function actualizarFechaVencimientoContrasena($ArrayUsuarios, $vigenciaPassword) {
             Usuario::actualizarFechaVencimientoContrasena($ArrayUsuarios, $vigenciaPassword);
        }

        public static function estadoFechaVencimientoContrasenia($user) {
           return Usuario::estadoFechaVencimientoContrasenia($user);
       }

       public static function estadoValidacionContrasenas($user, $contrasenia) {
        return Usuario::estadoValidacionContrasenas($user, $contrasenia);
       }
       public static function depurarTokenUsuario($usuario){
        Usuario::depurarToken($usuario);
       }
       public static function validarCorreoExiste($correo){
        return Usuario::correoExiste($correo);
       }
    }