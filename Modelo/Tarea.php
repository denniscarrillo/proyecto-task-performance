<?php

class Tarea {
        public $idTarea;
        public $idEstadoAvance;
        public $iCarteraCliente;
        public $titulo;
        public $idCliente;
        public $idUsuario;
        public $adjuntoFinalizacion;
        public $fechaInicio;
        public $fechaFinalizacion;
        public $chatComentario;
        public $idClasificacionLead;
        public $idOrigenLead;
        public $rubroComercial;
        public $razonSocial;
        public $estadoFinalizacion;
        //Campos de auditoria
        public $Creado_Por;
        public $Fecha_Creacion;
        public $Modificado_Por;
        public $Fecha_Modificacion;

        //METODOS DE LA CLASE
        public static function obtenerTareas($user){
            try {
                $con = new Conexion();
                $abrirConexion = $con->abrirConexionDB();
                $resultado = $abrirConexion->query('SELECT titulo, fecha_Inicio FROM tbl_Tarea');


            } catch (Exception $e) {
                $mensaje = 'Error SQL:'. $e;
            }
        }

}