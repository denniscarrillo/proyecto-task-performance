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

        public static function bitacorasUsuario(){
            return Bitacora::obtenerBitacorasUsuario();
        }
        
    }