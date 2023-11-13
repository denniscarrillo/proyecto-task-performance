<?php

class Porcentajes {
    public $idPorcentaje;
    public $valorPorcentaje;
    public $descripcionPorcentaje;
    public $estadoPorcentaje;
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;



    //Método para obtener todos los usuarios que existen.
    public static function obtenerPorcentajes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Porcentaje,valor_Porcentaje, descripcion, estado_Porcentaje
        FROM tbl_Porcentaje;";
        $listaPorcentajes = sqlsrv_query($consulta, $query);
        $Porcent = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaPorcentajes, SQLSRV_FETCH_ASSOC)){
            $Porcent [] = [
                'idPorcentaje' => $fila["id_Porcentaje"],
                'valorPorcentaje' => $fila["valor_Porcentaje"],
                'descripcionPorcentaje'=> $fila["descripcion"],
                'estadoPorcentaje' => $fila["estado_Porcentaje"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $Porcent;
    }

    //Método para crear eliminar registro
    public static function registroeliminarPorcentaje($eliminarPorcentaje){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
        $valorPorcentaje = $eliminarPorcentaje->valorPorcentaje;
        $descripcionPorcentaje = $eliminarPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $eliminarPorcentaje->estadoPorcentaje;
        $CreadoPor = $eliminarPorcentaje->CreadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $FechaCreacion = date("Y-m-d");
        $query = "INSERT INTO tbl_Porcentaje(valor_Porcentaje,descripcion,estado_Porcentaje, Creado_Por, Fecha_Creacion)
                       VALUES ('$valorPorcentaje', '$descripcionPorcentaje', '$estadoPorcentaje', '$CreadoPor', '$FechaCreacion');";        
        $eliminarPorcentaje = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $eliminarPorcentaje;
    }
    //Mètodo que divida el porcentaje entre 100
    public static function dividirPorcentaje($valorPorcentaje){
        $porcentaje = $valorPorcentaje/100;
        return $porcentaje;
    }

    public static function editarPorcentaje($eliminarPorcentaje){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idPorcentaje = $eliminarPorcentaje->idPorcentaje;
        // $valorPorcentaje = $eliminarPorcentaje->valorPorcentaje;
        // $descripcionPorcentaje =$eliminarPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $eliminarPorcentaje->estadoPorcentaje;
        $ModificadoPor = $eliminarPorcentaje->ModificadoPor;
        date_default_timezone_set('America/Tegucigalpa'); 
        $FechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_Porcentaje SET estado_Porcentaje ='$estadoPorcentaje', Modificado_Por = '$ModificadoPor', 
        Fecha_Modificacion = '$FechaModificacion' WHERE id_Porcentaje='$idPorcentaje';";
        $eliminarPorcentaje = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }

    public static function porcentajeExistente($valorPorcentaje){
        $existePorcentaje = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT valor_Porcentaje FROM tbl_Porcentaje WHERE valor_Porcentaje = '$valorPorcentaje'";
        $porcentajes = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($porcentajes);
        if($existe){
            $existePorcentaje = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existePorcentaje;
    }
    public static function eliminarPorcentaje($eliminarPorcentaje){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idPorcentaje = $eliminarPorcentaje->idPorcentaje;
        $estadoPorcentaje = $eliminarPorcentaje->estadoPorcentaje;
        $ModificadoPor = $eliminarPorcentaje->ModificadoPor;
        date_default_timezone_set('America/Tegucigalpa'); 
        $FechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_Porcentaje SET estado_Porcentaje ='$estadoPorcentaje', Modificado_Por = '$ModificadoPor', 
        Fecha_Modificacion = '$FechaModificacion' WHERE id_Porcentaje='$idPorcentaje';";
        $eliminarPorcentaje = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
}