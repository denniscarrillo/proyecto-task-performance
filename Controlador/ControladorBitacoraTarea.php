<?php

class ControladorBitacoraTarea {
    public static function agregarComentarioTarea($idTarea, $comentario, $CreadoPor){
        BitacoraTarea::agregarComentarioTarea($idTarea, $comentario, $CreadoPor);
    }
    public static function mostrarComentariosTarea($idTarea){
        return BitacoraTarea::mostrarComentariosTarea($idTarea);
    }
    public static function acciones_Evento_Tareas(){
        return BitacoraTarea::acciones_Evento_Tareas();
    }
    public static function SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser){
        BitacoraTarea::SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser);
    }
    public static function consultarBitacoraTarea($idTarea){
        return BitacoraTarea::consultarBitacoraTarea($idTarea);
    }
}