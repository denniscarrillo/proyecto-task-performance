<?php

class ControladorTarea {
    public static function obtenerTareasUsuario($idUser, $filtroTarea){
        return Tarea::obtenerTareas($idUser, $filtroTarea);
    }
}