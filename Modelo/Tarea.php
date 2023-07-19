<?php

class Tarea {
        public $idTarea;
        public $idEstadoAvance;
        public $iCarteraCliente;
        public $titulo;
        public $idCliente;
        public $idUsuario;
        public $fechaInicio;
        public $adjuntoFinalizacion;
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

        // Obtener todas las tareas que le pertenecen a un usuario.
        public static function obtenerTareas($idUser, $filtroTarea){
            $tareasUsuario = null;
            try {
                $tareasUsuario = array();
                $con = new Conexion();
                $abrirConexion = $con->abrirConexionDB();
                $resultado = $abrirConexion->query("SELECT t.titulo, t.fecha_Inicio, e.descripcion FROM tbl_Tarea AS t
                INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
                WHERE t.id_Usuario = $idUser;");
                //Recorremos el resultado de tareas y almacenamos en el arreglo.
                while($fila = $resultado->fetch_assoc()){
                    if($fila['descripcion'] == $filtroTarea){
                        $tareasUsuario [] = [
                            'tituloTarea' => $fila['titulo'],
                            'fechaInicio' => $fila['fecha_Inicio'],
                            'tipoTarea' => $fila['descripcion']
                        ];
                    }
                }
            } catch (Exception $e) {
                $tareasUsuario = 'Error SQL:'. $e;
            }
            mysqli_close($abrirConexion); //Cerrar conexion
            return $tareasUsuario;
        }


}