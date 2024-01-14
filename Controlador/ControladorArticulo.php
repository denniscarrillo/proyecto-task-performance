<?php

class ControladorArticulo {
    public static function obtenerTodosArticulos(){
        return Articulo::obtenerArticulo();
    }

    public static function obtenerArticuloxId($CodArt){
        return Articulo::obtenerArticuloxId($CodArt);
    }

    public static function obtenerArticuloPdf($buscar){
        return Articulo::obtenerArticuloPdf($buscar);
    }

    public static function registroNuevoArticulo($nuevoArticulo){
        return Articulo::registroNuevoArticulo($nuevoArticulo);
    }

    
    public static function editarArticulo($nuevoArticulo){
        return Articulo::editarArticulo($nuevoArticulo);
    }

    public static function eliminarArticulo($Articulos){
        return Articulo::eliminarArticulo($Articulos);
    }


}