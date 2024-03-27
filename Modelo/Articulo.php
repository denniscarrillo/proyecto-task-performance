<?php

class Articulo
{
    public $codArticulo;
    public $Articulo;
    public $Detalle;
    public $Marca;
    public $Precio;
    public $Existencias;
    //Campos de auditoria
    public $Creado_Por;
    public $Fecha_Creacion;
    public $Modificado_Por;
    public $Fecha_Modificacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerArticulos()
    {
        $articulo = null;
        try {
            $articulo = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT ROW_NUMBER() OVER(ORDER BY a.cod_Articulo ASC) AS Num, a.cod_Articulo, a.articulo, a.marca, p.precio, 
                a.detalle, a.existencia, a.Creado_Por, a.Fecha_Creacion FROM tbl_Articulos as a
                INNER JOIN tbl_Precios_Producto AS p  ON p.id_Precio = a.id_Precio";
            $resultado = sqlsrv_query($abrirConexion, $query);
            $articulo = array();
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $articulo[] = [
                    'item' => $fila['Num'],
                    'codigo' => $fila['cod_Articulo'],
                    'articulo' => $fila['articulo'],
                    'precio' => $fila['precio'],
                    'existencias' => $fila['existencia'],
                    'detalle' => $fila['detalle'],
                    'marcaArticulo' => $fila['marca'],
                    'creadoPor' => $fila['Creado_Por'],
                    'fechaCreacion' => $fila['Fecha_Creacion']
                ];
            }
        } catch (Exception $e) {
            $articulo = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $articulo;
    }

    public static function obtenerPreciosProductoPorID($codArticulo)
    {
        $articulo = array();
        $con = new Conexion();
        $abrirConexion = $con->abrirConexionDB();
        $query = "SELECT ROW_NUMBER() OVER(ORDER BY id_Precio ASC) AS Num, id_Precio, precio, estado_Precio FROM tbl_precios_producto WHERE cod_Articulo = '$codArticulo'";
        $resultado = sqlsrv_query($abrirConexion, $query);
        if(sqlsrv_errors() === null) {
          //Recorremos el resultado de tareas y almacenamos en el arreglo.
          while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $articulo [] = [
                'item' => $fila['Num'],
                'idPrecio' => $fila['id_Precio'],
                'precio' => $fila['precio'],
                'estado' => $fila['estado_Precio']
            ];
          }
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $articulo;
    }

    public static function nuevoPrecioArticulo($codArticulo,  $nuevoPrecio, $CreadoPor) {
      $conn = new Conexion();
      $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
      $insertPrecio = "INSERT INTO tbl_precios_producto(cod_Articulo, precio, estado_Precio, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion)
          VALUES('$codArticulo', '$nuevoPrecio', 'ACTIVO', '$CreadoPor', GETDATE(), '$CreadoPor', GETDATE())";
      sqlsrv_query($abrirConexion, $insertPrecio);

      //Obtenemos el id_Precio del recien creado
      $queryID = "SELECT SCOPE_IDENTITY() AS id_Precio";
      $resultado = sqlsrv_query($abrirConexion, $queryID);
      if(sqlsrv_errors() === null) {
        $idPrecio = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $idPrecio = $idPrecio['id_Precio'];
        $updatePrecios = "UPDATE tbl_precios_producto SET estado_Precio = 'INACTIVO', Modificado_Por = '$CreadoPor', Fecha_Modificacion = GETDATE()
        WHERE cod_Articulo = '$codArticulo' AND estado_Precio = 'ACTIVO' AND id_Precio != '$idPrecio'";
        sqlsrv_query($abrirConexion, $updatePrecios);
        return true;
      } else {
        return false;
      }
    }

    public static function actualizarPrecioArticulo($codArticulo,  $idNuevoPrecio, $CreadoPor) {
      $conn = new Conexion();
      $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
      $updatePrecio = "UPDATE tbl_Articulos SET id_Precio = '$idNuevoPrecio', Modificado_Por = '$CreadoPor', Fecha_Modificacion = GETDATE()
        WHERE cod_Articulo = '$codArticulo'";
      sqlsrv_query($abrirConexion, $insertPrecio);
      if(sqlsrv_errors() === null) {
        return true;
      } else {
        return false;
      }
    }

    public static function actualizarEstadoPrecio($idPrecio, $CodArticulo, $nuevoEstado, $CreadoPor) {
      $conn = new Conexion();
      $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
      $updateEstadoPrecio = "UPDATE tbl_precios_producto SET estado_Precio = '$nuevoEstado', Modificado_Por = '$CreadoPor', Fecha_Modificacion = GETDATE()
        WHERE id_Precio = '$idPrecio' AND cod_Articulo = '$CodArticulo'";
      sqlsrv_query($abrirConexion, $updateEstadoPrecio);
      if(sqlsrv_errors() === null) {
        return true;
      } else {
        return false;
      }
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
      $errores = array();
      $conn = new Conexion();
      $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
      $insertProducto = "INSERT INTO tbl_Articulos(articulo, detalle, marca, existencia, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) 
          VALUES('$nuevoArticulo->Articulo', '$nuevoArticulo->Detalle','$nuevoArticulo->Marca',  
          '$nuevoArticulo->Existencias', '$nuevoArticulo->Creado_Por', GETDATE(), '$nuevoArticulo->Creado_Por', GETDATE())";
      sqlsrv_query($abrirConexion, $insertProducto);

      //Obtenemos el CODIGO del producto recien creado
      $queryID = "SELECT SCOPE_IDENTITY() AS cod_Articulo";
      $resultado = sqlsrv_query($abrirConexion, $queryID);
      $codArticulo = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
      $codArticulo = $codArticulo['cod_Articulo'];
      //Teniendo el Cod producto se inserta su respectivo precio en la tabla Precios
      $insertPrecio = "INSERT INTO tbl_precios_producto(cod_Articulo, precio, estado_Precio, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion)
          VALUES('$codArticulo', '$nuevoArticulo->Precio', 'ACTIVO', '$nuevoArticulo->Creado_Por', GETDATE(), '$nuevoArticulo->Creado_Por', GETDATE())";
      sqlsrv_query($abrirConexion, $insertPrecio);

      //Ahora actualizamos el precio del producto en base a la tabla precios
      $updateProducto = "UPDATE tbl_Articulos SET id_Precio = (SELECT id_Precio FROM tbl_precios_producto WHERE cod_Articulo = '$codArticulo'), 
        Modificado_Por = '$nuevoArticulo->Creado_Por', Fecha_Modificacion = GETDATE() WHERE cod_Articulo = '$codArticulo'";
      sqlsrv_query($abrirConexion, $updateProducto);
      sqlsrv_close($abrirConexion); #Cerramos la conexión.
    }

    public static function editarArticulo($editarArticulo){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $update = "UPDATE tbl_Articulos SET articulo ='$editarArticulo->Articulo', detalle ='$editarArticulo->Detalle',
              marca ='$editarArticulo->Marca', existencia = '$editarArticulo->Existencias', id_Precio = '$editarArticulo->Precio', Modificado_Por='$editarArticulo->Modificado_Por', Fecha_Modificacion = GETDATE() 
              WHERE cod_Articulo ='$editarArticulo->codArticulo'";
            sqlsrv_query($abrirConexion, $update);
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
            $query = "SELECT CODARTICULO, ARTICULO, DETALLE, MARCA, Creado_Por FROM tbl_ARTICULOS
            WHERE CONCAT(CODARTICULO, ARTICULO, DETALLE, MARCA,Creado_Por) 
            LIKE '%' + '$buscar' + '%';";
            $resultado = sqlsrv_query($abrirConexion, $query);
            $articulo = array();
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $articulo[] = [
                    'codigo' => $fila['CODARTICULO'],
                    'articulo' => $fila['ARTICULO'],
                    'detalle' => $fila['DETALLE'],
                    'marcaArticulo' => $fila['MARCA'],
                    'CreadoPor' => $fila['Creado_Por']
                ];
            }
        } catch (Exception $e) {
            $articulo = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $articulo;
    }

    public static function eliminarArticulo($CodArticulo){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_Articulos WHERE cod_Articulo  = '$CodArticulo'";
            sqlsrv_query($conexion, $query);
            if(sqlsrv_errors() == null) {
                return true;
            }
            sqlsrv_close($conexion); //Cerrar conexion
            return false;
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
    }
}