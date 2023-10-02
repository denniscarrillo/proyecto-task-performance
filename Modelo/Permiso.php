<?php

class Permiso
{
    public $idRol;
    public $idObjeto;
    public $permisoConsultar;
    public $permisoInsercion;
    public $permisoActualizacion;
    public $permisoEliminacion;
    //Campos de auditoria
    public $Creado_Por;
    public $Fecha_Creacion;
    public $Modificado_Por;
    public $Fecha_Modificacion;

    // Obtener todas las permisos del rol sobre los objetos del sistema.
    public static function obtenerPermisos(){
        $permisos = null;
        try {
            $permisos = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query="SELECT r.rol, o.objeto, p.permiso_Consultar, p.permiso_Insercion, 
            p.permiso_Actualizacion, p.permiso_Eliminacion FROM tbl_ms_permisos p
            INNER JOIN tbl_ms_objetos o ON o.id_Objeto = p.id_Objeto
            INNER JOIN tbl_ms_roles r ON p.id_Rol = r.id_Rol;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $permisos[] = [
                    'rolUsuario' => $fila['rol'],
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
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $permisos;
    }
    public static function obtenerObjetos(){
        $objetos = null;
        try {
            $objetos = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query="SELECT id_Objeto, objeto, descripcion FROM tbl_ms_objetos;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
                $objetos [] = [
                    'id_Objeto' => $fila["id_Objeto"],
                    'objeto' => $fila["objeto"],
                    'descripcion' => $fila["descripcion"]
                ];
            }
        } catch (Exception $e) {
            $objetos = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $objetos;
    }
    public static function registroPermiso($idRol, $idObjetos, $creadoPor) {
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            foreach($idObjetos as $idObjeto){
                $id = $idObjeto['id_Objeto'];
                $query = "INSERT INTO tbl_ms_permisos (id_Rol, id_Objeto, permiso_Consultar, permiso_Insercion, 
                permiso_Actualizacion, permiso_Eliminacion, Creado_Por, Fecha_Creacion) VALUES ('$idRol', '$id', 'N', 'N', 'N', 'N', '$creadoPor', GETDATE());";
                sqlsrv_query($abrirConexion, $query);
            }
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerIdRolObjeto($rol, $objeto){
        $arrayId = array();
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $queryIdRol = "SELECT id_Rol FROM tbl_MS_Roles WHERE rol = '$rol';";
            $resultadoIdRol = sqlsrv_query($conexion, $queryIdRol);
            $filaRol = sqlsrv_fetch_array($resultadoIdRol, SQLSRV_FETCH_ASSOC);
            $idRol = $filaRol['id_Rol'];
            $queryIdObjeto = "SELECT id_Objeto FROM tbl_MS_Objetos WHERE objeto = '$objeto'";
            $resultadoIdObjeto = sqlsrv_query($conexion, $queryIdObjeto);
            $filaObjeto = sqlsrv_fetch_array($resultadoIdObjeto, SQLSRV_FETCH_ASSOC);
            $idObjeto = $filaObjeto['id_Objeto'];
            $arrayId = [
                'idRol' => $idRol,
                'idObjeto' => $idObjeto
            ];
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $arrayId;
    }
    public static function actualizarPermisos($permisos){
        $arrayId = array();
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "UPDATE tbl_MS_Permisos SET permiso_Consultar='$permisos->permisoConsultar', permiso_Insercion='$permisos->permisoInsercion', 
            permiso_Actualizacion='$permisos->permisoActualizacion', permiso_Eliminacion='$permisos->permisoEliminacion', Modificado_Por='$permisos->Modificado_Por', 
            Fecha_Modificacion = GETDATE() WHERE id_Rol='$permisos->idRol' AND id_Objeto='$permisos->idObjeto';";
            $resultado = sqlsrv_query($conexion, $query);
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $arrayId;
    }
    public static function obtenerPermisosUsuario($usuario) {
        $permisos = array();
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "SELECT pe.id_Objeto, pe.permiso_Consultar FROM tbl_MS_Permisos pe
            INNER JOIN tbl_MS_Usuario us ON pe.id_Rol = us.id_Rol
            WHERE us.usuario = '$usuario' and pe.permiso_Consultar = 'Y';";
            $resultado = sqlsrv_query($conexion, $query);
            while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
                $permisos [] = [
                    'idObjeto' => $fila['id_Objeto'],
                    'permisoConsultar' => $fila['permiso_Consultar']
                ];
            }
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $permisos;
    }
    public static function obtenerPermisosObjeto($usuario, $idObjeto){
        $permisos = array();
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "SELECT pe.permiso_Insercion, pe.permiso_Actualizacion, pe.permiso_Eliminacion FROM tbl_MS_Permisos pe
            INNER JOIN tbl_MS_Usuario us ON pe.id_Rol = us.id_Rol
            WHERE us.usuario = '$usuario' AND pe.id_Objeto = '$idObjeto';";
            $resultado = sqlsrv_query($conexion, $query);
            $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            $permisos = [
                'Insertar' => $fila['permiso_Insercion'],
                'Actualizar' => $fila['permiso_Actualizacion'],
                'Eliminar' => $fila['permiso_Eliminacion']
            ];
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion);
        return $permisos;
    }
}