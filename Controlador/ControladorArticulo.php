<?php

class ControladorArticulo {
    public static function obtenerTodosArticulos(){
        return Articulo::obtenerArticulos();
    }

    public static function obtenerArticuloxId($CodArt){
        return Articulo::obtenerArticuloxId($CodArt);
    }

    public static function obtenerArticuloPdf($buscar){
        return Articulo::obtenerArticuloPdf($buscar);
    }

    public static function registroNuevoArticulo($nuevoArticulo){
        Articulo::registroNuevoArticulo($nuevoArticulo);
    }

    
    public static function editarArticulo($editarArticulo){
        Articulo::editarArticulo($editarArticulo);
    }

    public static function eliminarArticulo($CodArticulo){
        return Articulo::eliminarArticulo($CodArticulo);
    }

    public static function obtenerPreciosProductoPorID($codArticulo){
        return Articulo::obtenerPreciosProductoPorID($codArticulo);
    }

    public static function nuevoPrecioArticulo($codArticulo,  $nuevoPrecio, $CreadoPor) {
        return Articulo::nuevoPrecioArticulo($codArticulo,  $nuevoPrecio, $CreadoPor);
    }

    public static function actualizarPrecioArticulo($codArticulo, $idNuevoPrecio, $CreadoPor) {
        return Articulo::actualizarPrecioArticulo($codArticulo,  $idNuevoPrecio, $CreadoPor);
    }

    public static function actualizarEstadoPrecio($idPrecio, $CodArticulo, $nuevoEstado, $CreadoPor) {
        return Articulo::actualizarEstadoPrecio($idPrecio, $CodArticulo, $nuevoEstado, $CreadoPor);
    }

}