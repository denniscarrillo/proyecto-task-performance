<?php

class ControladorTarea {
    public static function obtenerTareasUsuario($idUser){
        return Tarea::obtenerTareas($idUser);
    }
    public static function insertarNuevaTarea($tarea){
        return Tarea::nuevaTarea($tarea); 
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
    public static function obtenerVendedoresTarea($idTarea){
        return Tarea::obtenerVendedores($idTarea);
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
    public static function guardarFacturaTarea($idTarea, $evidencia, $accion, $creadoPor){
        Tarea::guardarFacturaTarea($idTarea, $evidencia, $accion, $creadoPor);
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
    public static function editarNuevoClienteTarea($editarClienteTarea){
        Tarea::editarNuevoClienteTarea($editarClienteTarea);
    }
    public static function obtenerRTN_Tarea($idTarea){
        return Tarea::obtenerRtnClienteTarea($idTarea);
    }
    public static function obtenerDatos($idTarea, $estadoCliente){
        return Tarea::obtenerDatos($idTarea, $estadoCliente);
    }
    public static function nuevaCotizacion($nuevaCotizacion, $creadoPor){
        return Tarea::nuevaCotizacion($nuevaCotizacion, $creadoPor);
    }
    public static function productosCotizacion($idCotizacion, $productosCotizacion, $creadoPor){
        Tarea::productosCotizacion($idCotizacion, $productosCotizacion, $creadoPor);
    }
    public static function obtenerDatosCotizacion($idTarea){
        return Tarea::obtenerDatosCotizacion($idTarea);
    }
    public static function almacenarProducto($producto) {
        return Tarea::almacenarProductoCotizacion($producto);
    }
    public static function anularCotizacion($idCotizacion, $modificadoPor){
        return Tarea::anularCotizacion($idCotizacion, $modificadoPor);
    }
    public static function calcularVencimientoCotizacion($idCotizacion){
        return Tarea::calcularVencimientoCotizacion($idCotizacion);
    }
    public static function vencimientoEstadoCotizacion($idCotizaciones){
        Tarea::vencimientoEstadoCotizacion($idCotizaciones);
    }
    public static function obtenerCotizacionesUsuario($usuario){
        return Tarea::obtenerCotizacionesUsuario($usuario);
    }
    public static function obtenerCotizacionesUsuarioPDF($usuario, $buscar){
        return Tarea::obtenerCotizacionesUsuarioPDF($usuario, $buscar);
    }
    public static function obtenerCotizacionXId($idCotizacion){
        return Tarea::obtenerCotizacionXId($idCotizacion);
    }
    public static function obtenerProductosInteres($idTarea){
        return Tarea::obtenerProductosInteres($idTarea);
    }
    // public static function obtenerHistorialEstadosTarea($idTarea){
    //     return Tarea::obtenerHistorialEstadosTarea($idTarea);
    // }
    public static function actualizarEstadoTarea($idTarea, $newEstado, $usuario){
        Tarea::cambiarEstadoTarea($idTarea, $newEstado, $usuario);
    }
    public static function obtenerEstadoTarea($idTarea){
        return Tarea::obtenerEstadoTarea($idTarea);
    }
    public static function obtenerIdCotizacionTarea($idTarea){
        return Tarea::obtenerIdCotizacionTarea($idTarea);
    }
    public static function finalizarTarea($idTarea){
        return Tarea::finalizarTarea($idTarea);
    }
    public static function obtenerTareaFinalizada($idTarea){
        return Tarea::obtenerTareaFinalizada($idTarea);
    }
    public static function reabrirTarea($idTarea){
        return Tarea::reabrirTarea($idTarea);
    }
    public static function validarClienteExistenteCarteraCliente($rtn){
        return Tarea::validarClienteExistenteCarteraCliente($rtn);
    }
    public static function validarSiExisteEvidencia($evidencia){
        return Tarea::validarSiExisteEvidencia($evidencia);
    }
    public static function existeFacturaEvidencia($cif, $codCliente, $numFactura){
        return Tarea::validarFacturaEvidencia($cif, $codCliente, $numFactura);
    }
    public static function obtenerLlaveUnicaClienteTarea($idTarea){
        return Tarea::obtenerLlaveUnicaClienteTarea($idTarea);
    }
    public static function obtenerTipoCliente($idTarea){
        return Tarea::obtenerTipoCliente($idTarea);
    }
    public static function obtenerRazonSocial(){
        return Tarea::obtenerRazonSocial();
    }
    public static function obtenerRubroComercial(){
        return Tarea::obtenerRubroComercial();
    }
}