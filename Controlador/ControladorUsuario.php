<?php
    class ControladorUsuario {
        
        public static function getUsuarios(){
            require_once('Modelo/Usuario.php');
            $Usuarios = Usuario::obtenerUsuarios();
            return $Usuarios; 
        }
        public static function login($usuario, $contrasenia){
            $valido = false;
            $usuario = Usuario::buscarUsuario($usuario, $contrasenia);
            if($usuario > 0){
                $valido = true;
            }
            return $valido;
        }

        public function registro($nuevoUsuario){
            $usuario = new Usuario();
            $usuario->ingresarUsuarios($nuevoUsuario);
        }
        public static function intentosLogin(){
            return  Usuario::intentosValidos();
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
    }