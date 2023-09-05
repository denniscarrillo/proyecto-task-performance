<?php

class ControladorTipoServicio {

    public static function TipoServicio($id_TipoServicio){
        $valido = false;
        $id_TipoServicio = TipoServicio::existeTipoServicio($id_TipoServicio);
        if($id_TipoServicio > 0){
            $valido = true;
        }
        return $valido;
    }
    public static function obtenerTipoServicio(){
        return TipoServicio::obtenerTodosLosTipoServicio();
    }
    public static function ingresarNuevoTipoServicio($nuevoTipoServicio){
        return TipoServicio::registroTipoServicio($nuevoTipoServicio);
    }   
    public static function editarNuevoTipoServicio($nuevoTipoServicio){
       return TipoServicio::editarTipoServicio($nuevoTipoServicio);
    }

}