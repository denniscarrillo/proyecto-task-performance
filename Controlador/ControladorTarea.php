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
    public static function obtenerArticulosTarea(){
        return Tarea::obtenerArticulos();
    }
    public static function traerEstadosTarea(){
        return Tarea::obtenerEstadosTarea();
    }
    public static function validarRtnCliente($rtn){
        return Tarea::validarTipoCliente($rtn);
    }
    public static function obtenerClientesTarea(){
        return Tarea::obtenerClientes();
    }
    public static function agregarVendores($idTarea, $idVendores){
        Tarea::agregarVendedoresTarea($idTarea, $idVendores);
    }
    public static function obtenerVendedoresTarea(){
        return Tarea::obtenerVendedores();
    }
    public static function obtenerClasificacionLead(){
        return Tarea::obtenerClasificacionLead();
    }
    public static function obtenerOrigenLead(){
        return Tarea::obtenerOrigenLead();
    }
    public static function actualizarTarea($idTarea, $tipoTarea, $datosTarea){
        Tarea::editarTarea($idTarea, $tipoTarea, $datosTarea);
    }
    public static function insertarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion, $Creado_Por){
        Tarea::agregarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion, $Creado_Por);
    }
    public static function almacenarProductosInteres($idTarea, $productos){
        Tarea::guardarProductosInteres($idTarea, $productos);
    }

    public static function obtenerCantTareas($FechaDesde, $FechaHasta){
        return Tarea::obtenerCantTarea($FechaDesde, $FechaHasta);
    }
}