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
        Articulo::registroNuevoArticulo($nuevoArticulo);
    }

    
    public static function editarArticulo($editarArticulo){
        Articulo::editarArticulo($editarArticulo);
    }

    public static function eliminarArticulo($CodArticulo){
        return Articulo::eliminarArticulo($CodArticulo);
    }


}