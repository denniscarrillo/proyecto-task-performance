<?php

class ControladorTarea {
    public static function obtenerTareasUsuario($idUser){
        return Tarea::obtenerTareas($idUser);
    }
    public static function insertarNuevaTarea($tarea){
        Tarea::nuevaTarea($tarea); 
    }
    public static function obtenerestadoClienteTarea($rtnCliente){
        return Tarea::clienteExistente($rtnCliente); 
    }
}