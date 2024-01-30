<?php 
    Class ControladorEstadoUsuario{
        public static function obtenerEstadoUsuario(){
            return EstadoUsuario::obtenerEstadoUsuario();
        }
        public static function InsertarNuevoEstado($estado, $usuario){
            return EstadoUsuario::InsertarNuevoEstado($estado, $usuario);
        }

        public static function editarEstadoU($editarEstado){
            return EstadoUsuario::editarEstadoU($editarEstado);
        }

        public static function eliminarEstadoU($idEstadoU){
            return  EstadoUsuario::eliminarEstadoU($idEstadoU);
        }

        public static function obtenerLosEstadoUsuarioPDF($buscar){
            return  EstadoUsuario::obtenerLosEstadoUsuarioPDF($buscar);
        }
    }