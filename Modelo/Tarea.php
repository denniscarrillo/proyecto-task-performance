<?php

class Tarea
{
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
    public static function obtenerTareas($idUser)
    {
        $tareasUsuario = null;
        try {
            $tareasUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $resultado = $abrirConexion->query("SELECT t.titulo, t.fecha_Inicio, e.descripcion FROM tbl_Tarea AS t
                INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
                WHERE t.id_Usuario = $idUser;");
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = $resultado->fetch_assoc()) {
                $tareasUsuario[] = [
                    'tipoTarea' => $fila['descripcion'],
                    'tituloTarea' => $fila['titulo'],
                    'fechaInicio' => $fila['fecha_Inicio'],
                ];
            }
        } catch (Exception $e) {
            $tareasUsuario = 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
        return $tareasUsuario;
    }

    public static function nuevaTarea($tarea)
    {
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $insert = "INSERT INTO `tbl_tarea` (`id_Usuario`, `id_EstadoAvance`, `titulo`, `fecha_Inicio`, `Creado_Por`, `Fecha_Creacion`) 
                            VALUES ('$tarea->idUsuario', '$tarea->idEstadoAvance','$tarea->titulo', 
                                    '$tarea->fechaInicio', '$tarea->Creado_Por', '$tarea->fechaInicio');";
            $abrirConexion->query($insert);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerEstadoClienteTarea($rtnCliente)
    {
        try {
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT estado_Cliente_Tarea 
            FROM tbl_tarea WHERE id_EstadoAvance = 4 AND RTN_Cliente = '$rtnCliente'";
            $estadoCliente = $abrirConexion->query($select);
            while ($fila = $estadoCliente->fetch_assoc()) {
                $estado [] = [
                    'estadoClienteTarea' => $fila['estado_Cliente_Tarea']
                ];
            }
            return $estado;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
}
