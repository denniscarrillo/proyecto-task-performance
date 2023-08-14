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
            $resultado = $abrirConexion->query("SELECT CODARTICULO, ARTICULO, DETALLE, MARCA FROM view_articulos;");
            $articulo = array();
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = $resultado->fetch_assoc()) {
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
        mysqli_close($abrirConexion); //Cerrar conexion
        return $articulo;
    }
}