<?php

class Parametro {
    public $idParametro;
    public $parametro;
    public $valor;
    public $nombre;
    public $idUsuario;
    public $creadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    //Método para obtener todos los usuarios que existen.
    public static function obtenerTodosLosParametros(){
        $parametros = null;
        try {
            $parametros = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT p.id_Parametro, p.parametro, p.valor, u.usuario FROM tbl_ms_parametro AS p
            INNER JOIN tbl_ms_usuario AS u ON p.id_Usuario = u.id_Usuario;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $parametros[] = [
                    'id' => $fila['id_Parametro'],
                    'parametro' => $fila['parametro'],
                    'valorParametro' => $fila['valor'],
                    'usuario' => $fila['usuario'],
                ];
            }
        } catch (Exception $e) {
            $parametros = 'Error SQL:' . $e;
        }
       sqlsrv_close($abrirConexion); //Cerrar conexion
        return $parametros;
    }
    public static function editarParametros($nuevoParametro){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevoParametro->idParametro;
            $parametro=$nuevoParametro->parametro;
            $valor=$nuevoParametro->valor;
            $query = "UPDATE tbl_ms_parametro SET parametro='$parametro', valor='$valor' WHERE id_Parametro='$id' ";
            $nuevoParametro = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
       sqlsrv_close($abrirConexion); //Cerrar conexion
    }
}
