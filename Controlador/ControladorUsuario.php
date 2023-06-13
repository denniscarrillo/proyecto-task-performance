<?php
    // require_once ("../../Modelo/Usuario.php");
    class ControladorUsuario {
        
        public static function getUsuarios(){
            require_once('Modelo/Usuario.php');
            $Usuarios = Usuario::obtenerUsuarios();
            return $Usuarios; 
        }

        // public static function login($usuario, $contrasenia){
        //     $Usuarios = Usuario::obtenerUsuarios();
        //     for($i = 0; $i < count($Usuarios); $i++){
        //         if($Usuarios[$i][1]==$usuario && $Usuarios[$i][3]==$contrasenia){
        //             $valido = true;
        //         }
        //     }
        //     return $valido;
        // }

        public static function login($usuario, $contrasenia){
            $valido = false;
            $usuario = Usuario::buscarUsuario($usuario, $contrasenia);
            if($usuario > 0){
                $valido = true;
            }
            return $valido;
        }

    }
?>