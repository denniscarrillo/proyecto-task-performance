<?php

class ControladorBitacoraTarea {
    public static function agregarComentarioTarea($idTarea, $comentario, $CreadoPor){
        return BitacoraTarea::agregarComentarioTarea($idTarea, $comentario, $CreadoPor);
    }
    public static function mostrarComentariosTarea($idTarea){
        return BitacoraTarea::mostrarComentariosTarea($idTarea);
    }
    public static function SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser){
        return BitacoraTarea::SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser);
    }
    public static function guardarBitacoraComentario($idBitacora, $idComentario){
        BitacoraTarea::guardarBitacoraComentario($idBitacora, $idComentario);
    }
    public static function consultarBitacoraTarea($idTarea){
        return BitacoraTarea::consultarBitacoraTarea($idTarea);
    }
    public static function obtenerEstadoTarea($idEstado){
        return BitacoraTarea::obtenerEstadoTarea($idEstado);
    }
    public static function obtenerEstadoAvanceTarea($idTarea){
        return BitacoraTarea::obtenerEstadoAvanceTarea($idTarea);
    }
    public static function obtenerUsuario($idUsuario){
        return BitacoraTarea::obtenerUsuario($idUsuario);
    }
}