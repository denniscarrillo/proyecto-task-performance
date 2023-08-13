<?php

class ControladorArticulo {
    public static function obtenerTodosArticulos(){
        return Articulo::obtenerArticulo();
    }
}