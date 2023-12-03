<?php 
    Class ControladorEstadoUsuario{
        public static function obtenerEstadoUsuario(){
            return EstadoUsuario::obtenerEstadoUsuario();
        }
        public static function InsertarNuevoEstado($estado, $usuario){
            return EstadoUsuario::InsertarNuevoEstado($estado, $usuario);
        }
    }