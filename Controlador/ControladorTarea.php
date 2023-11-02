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

    public static function obtenerCantTareasPorVendedor($idUsuario_Vendedor, $FechaDesde, $FechaHasta){
        return Tarea::obtenerTareaPorVendedor($idUsuario_Vendedor, $FechaDesde, $FechaHasta);
    }
    public static function validarEstadoClienteTarea($idTarea){
        return Tarea::validarEstadoCliente($idTarea);
    }
    public static function obtenerDatosTarea ($tipoTarea, $idTarea) {
        return Tarea::obtenerDatosClienteTarea($tipoTarea, $idTarea);
    }
    public static function agregarComentarioTarea($idTarea, $comentario, $CreadoPor){
        Tarea::agregarComentarioTarea($idTarea, $comentario, $CreadoPor);
    }
    public static function mostrarComentariosTarea($idTarea){
        return Tarea::mostrarComentariosTarea($idTarea);
    }
    public static function acciones_Evento_Tareas(){
        return Tarea::acciones_Evento_Tareas();
    }
    public static function SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser){
        Tarea::SAVE_EVENT_TASKS_BITACORA($eventoTarea, $idUser);
    }
    public static function consultarBitacoraTarea($idTarea){
        return Tarea::consultarBitacoraTarea($idTarea);
    }
    public static function editarNuevoClienteTarea($editarClienteTarea){
        Tarea::editarNuevoClienteTarea($editarClienteTarea);
    }
    public static function obtenerRTN_Tarea($idTarea){
        return Tarea::obtenerRtnClienteTarea($idTarea);
    }
}