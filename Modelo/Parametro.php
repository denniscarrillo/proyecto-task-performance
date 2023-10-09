<?php

class Parametro {
    public $idParametro;
    public $parametro;
    public $valor;
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
            $query = "SELECT p.id_Parametro, p.parametro, p.valor, p.descripcion, u.usuario FROM tbl_ms_parametro p
            INNER JOIN tbl_ms_usuario u ON p.id_Usuario = u.id_Usuario;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $parametros[] = [
                    'id' => $fila['id_Parametro'],
                    'parametro' => $fila['parametro'],
                    'valorParametro' => $fila['valor'],
                    'descripcionParametro' => $fila['descripcion'],
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
            $usuario=$nuevoParametro->idUsuario;
            $ModificadoPor=$nuevoParametro->ModificadoPor;
            date_default_timezone_set('America/Tegucigalpa');
            $fechaModificacion = date("Y-m-d");
            $query = "UPDATE tbl_ms_parametro SET parametro='$parametro', valor='$valor', id_Usuario='$usuario', Modificado_Por='$ModificadoPor', Fecha_Modificacion='$fechaModificacion'  WHERE id_Parametro='$id' ";
            $nuevoParametro = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
       sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function dataServerEmail(){
        try{
            $parametrosEmail = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB();
            $query = "SELECT valor FROM tbl_MS_Parametro WHERE id_Parametro IN(3,4,5,6);";
            $resultado = sqlsrv_query($abrirConexion, $query);
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $parametrosEmail[] = [
                    'valorParametro' => $fila['valor']
                ];
            }
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $parametrosEmail;
    }
    public static function obtenerVigencia(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT valor FROM  tbl_MS_Parametro where parametro = 'ADMIN VIGENCIA'";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $vigencia = [
            'Vigencia' => $fila['valor']   
        ];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $vigencia;
    }
    public static function obtenerVigenciaToken(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT valor FROM  tbl_MS_Parametro where parametro = 'HORAS VIGENCIA TOKEN'";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $vigencia =  $fila['valor'];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $vigencia;
    }
}