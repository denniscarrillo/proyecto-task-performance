<?php
    // require_once ("../../Modelo/Usuario.php");
    
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

    }
?>