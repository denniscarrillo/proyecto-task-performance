<?php

class Articulo
{
    public $codArticulo;
    public $articulo;
    public $detalle;
    public $marca;
    //Campos de auditoria
    public $Creado_Por;
    public $Fecha_Creacion;
    public $Modificado_Por;
    public $Fecha_Modificacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerArticulo()
    {
        $articulo = null;
        try {
            $articulo = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT CODARTICULO, ARTICULO, DETALLE, MARCA FROM view_articulos;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            $articulo = array();
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $articulo[] = [
                    'codigo' => $fila['CODARTICULO'],
                    'articulo' => $fila['ARTICULO'],
                    'detalle' => $fila['DETALLE'],
                    'marcaArticulo' => $fila['MARCA']
                ];
            }
        } catch (Exception $e) {
            $articulo = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $articulo;
    }


    public static function obtenerArticuloxId($CodArt){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT ARTICULO FROM view_articulos where CODARTICULO = $CodArt;";
        $resultado = sqlsrv_query($consulta, $query);
        $articulo = sqlsrv_fetch($resultado, SQLSRV_FETCH_ASSOC);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $articulo;
    }

}