<?php
    class ControladorCarteraClientes {
        
        public static function obtenerCarteraClientes(){
            return CarteraClientes::obtenerCarteraClientes();
        }

        public static function registroCliente($nuevoCliente){
            return CarteraClientes::registroNuevoCliente($nuevoCliente);
        }

        public static function editarCliente($Cliente){
            CarteraClientes::editarCliente($Cliente);
        }

        public static function rtnExiste($rtn){
            return CarteraClientes::rtnExistente($rtn);
        }
        
      /**
      *Elimina un cliente, devuelve `true` si fue eliminado y `false` en caso contrario
      *@param string $rtnCliente
      *@return boolean true | false
      */
        public static function eliminarCliente($rtnCliente){
            return CarteraClientes::eliminarCliente($rtnCliente);
        }

        public static function obtenerCarteraClientesPDF($buscar){
            return CarteraClientes::obtenerCarteraClientesPDF($buscar);
        }
    
    }

    