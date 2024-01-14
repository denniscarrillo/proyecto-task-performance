<?php

class Articulo
{
    public $codArticulo;
    public $Articulo;
    public $Detalle;
    public $Marca;
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
            $query = "SELECT CODARTICULO, ARTICULO, DETALLE, MARCA FROM tbl_ARTICULOS;";
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
        $query = "SELECT ARTICULO FROM tbl_ARTICULOS where CODARTICULO = $CodArt;";
        $resultado = sqlsrv_query($consulta, $query);
        $articulo = array();
        //Recorremos el resultado de tareas y almacenamos en el arreglo.
        while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $articulo[] = [
                'articulo' => $fila['ARTICULO'],
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $articulo;
    }

    public static function registroNuevoArticulo($nuevoArticulo){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
       // $codArticulo = $nuevoArticulo->codArticulo;
        $Articulo = $nuevoArticulo->Articulo;
        $Detalle = $nuevoArticulo->Detalle;
        $Marca = $nuevoArticulo->Marca;
        $query = "INSERT INTO tbl_ARTICULOS( ARTICULO, DETALLE,MARCA) 
        VALUES  ('$Articulo', '$Detalle','$Marca');";
        $nuevoArticulo = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $nuevoArticulo;
    }

    public static function editarArticulo($nuevoArticulo){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $codArticulo = $nuevoArticulo->codArticulo;
            $Articulo = $nuevoArticulo->Articulo;
            $Detalle = $nuevoArticulo->Detalle;
            $Marca = $nuevoArticulo->Marca;
            $update = "	UPDATE tbl_ARTICULOS SET ARTICULO='$Articulo' ,DETALLE='$Detalle',MARCA='$Marca' WHERE CODARTICULO='$codArticulo' ";
            $nuevoArticulo = sqlsrv_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }

    public static function obtenerArticuloPdf($buscar)
    {
        $articulo = null;
        try {
            $articulo = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT CODARTICULO, ARTICULO, DETALLE, MARCA FROM tbl_ARTICULOS
            WHERE CONCAT(CODARTICULO, ARTICULO, DETALLE, MARCA) 
            LIKE '%' + '$buscar' + '%';";
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

    public static function eliminarArticulo($articulo){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_ARTICULOS WHERE CODARTICULO  = '$CodArticulo';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }

}