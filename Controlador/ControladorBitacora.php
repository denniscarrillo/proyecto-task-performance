<?php
    class ControladorBitacora {
        public static function SAVE_EVENT_BITACORA($datosEvento){
            Bitacora::EVENT_BITACORA($datosEvento);
        }
        public static function obtenerIdObjeto($objeto){
           return Bitacora::obtener_Id_Objeto($objeto);
        }
        public static function accion_Evento(){
            return Bitacora::acciones_Evento();
         }
        public static function bitacorasUsuario($fechaDesde, $fechaHasta){
            return Bitacora::obtenerBitacorasUsuario($fechaDesde, $fechaHasta);
        }
        public static function depurarBitacoraSistema($fechaDesde, $fechaHasta){
            return Bitacora::depurarBitacora($fechaDesde, $fechaHasta);
        }
        public static function getBitacoraPdf($buscar, $fechaDesde, $fechaHasta){
            return Bitacora::obtenerBitacoraPdf($buscar, $fechaDesde, $fechaHasta);
        }
    }