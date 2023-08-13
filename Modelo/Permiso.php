<?php

class Permiso
{
    public $idRol;
    public $idObjeto;
    public $permisoConsultar;
    public $PermisoInsercion;
    public $PermisoActualizacion;
    public $PermisoEliminacion;
    //Campos de auditoria
    public $Creado_Por;
    public $Fecha_Creacion;
    public $Modificado_Por;
    public $Fecha_Modificacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerPermisos()
    {
        $permisos = null;
        try {
            $permisos = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $resultado = $abrirConexion->query("SELECT r.descripcion, o.objeto, p.permiso_Consultar, p.permiso_Insercion, 
            p.permiso_Actualizacion, p.permiso_Eliminacion FROM cocinas_y_equipos.tbl_ms_permisos p
            INNER JOIN tbl_ms_objetos o ON o.id_Objeto = p.id_Objeto
            INNER JOIN tbl_ms_roles r ON p.id_Rol = r.id_Rol;");
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = $resultado->fetch_assoc()) {
                $permisos[] = [
                    'rolUsuario' => $fila['descripcion'],
                    'objetoSistema' => $fila['objeto'],
                    'consultar' => $fila['permiso_Consultar'],
                    'insertar' => $fila['permiso_Insercion'],
                    'actualizar' => $fila['permiso_Actualizacion'],
                    'eliminar' => $fila['permiso_Eliminacion']
                ];
            }
        } catch (Exception $e) {
            $permisos = 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
        return $permisos;
    }
}