<?php

class ControladorDataTableObjeto {

  
    public static function DataTableObjeto(){
        return DataTableObjeto::obtenerObjetos();
    }
    public static function ObtenerIdObjetos(){
        return DataTableObjeto::obtenerIdObjetos();
    }
}