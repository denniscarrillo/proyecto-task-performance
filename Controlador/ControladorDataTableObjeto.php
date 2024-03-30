<?php

class ControladorDataTableObjeto {

  
    public static function DataTableObjeto(){
        return DataTableObjeto::obtenerObjetos();
    }
    public static function ObtenerIdObjetos(){
        return DataTableObjeto::obtenerIdObjetos();
    }
    public static function obtenerObjetosPdf($buscar){
        return DataTableObjeto::obtenerObjetosPdf($buscar);
    }
    public static function CrearObjeto($nuevoObjeto){
        return DataTableObjeto::CrearObjeto($nuevoObjeto);
    }

    public static function editarObjeto($editarObjeto){
        return DataTableObjeto::editarObjeto($editarObjeto);
    }

    public static function eliminarObjeto($id_Objeto, $objeto){
        return  DataTableObjeto::eliminarObjeto($id_Objeto, $objeto);
    }
}