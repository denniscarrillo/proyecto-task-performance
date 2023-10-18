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

    //Método para crear nuevo registro
    public static function registroNuevoPorcentaje($nuevoPorcentaje){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
        $valorPorcentaje = $nuevoPorcentaje->valorPorcentaje;
        $descripcionPorcentaje = $nuevoPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $nuevoPorcentaje->estadoPorcentaje;
        $CreadoPor = $nuevoPorcentaje->CreadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $FechaCreacion = date("Y-m-d");
        $query = "INSERT INTO tbl_Porcentaje(valor_Porcentaje,descripcion,estado_Porcentaje, Creado_Por, Fecha_Creacion)
                       VALUES ('$valorPorcentaje', '$descripcionPorcentaje', '$estadoPorcentaje', '$CreadoPor', '$FechaCreacion');";        
        $nuevoPorcentaje = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $nuevoPorcentaje;
    }
    //Mètodo que divida el porcentaje entre 100
    public static function dividirPorcentaje($valorPorcentaje){
        $porcentaje = $valorPorcentaje/100;
        return $porcentaje;
    }

    public static function editarPorcentaje($nuevoPorcentaje){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_Porcentaje SET  estado_Porcentaje = '$nuevoPorcentaje->estadoPorcentaje', Modificado_Por = '$nuevoPorcentaje->ModificadoPor', Fecha_Modificacion = '$nuevoPorcentaje->FechaModificacion' WHERE id_Porcentaje = '$nuevoPorcentaje->idPorcentaje'";
        $editarPorcentaje = sqlsrv_query($conexion, $query);
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
    public static function obtenerEstadoPorcentaje($idPorcentaje){
        $estadoP = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Porcentaje FROM tbl_Porcentaje WHERE  = 'Activo'";
        $estadoPorcentaje = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($estadoPorcentaje);
        if($existe > 0){
            $estadoP = true;
        } else {
            $estadoP = false;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoP;
    }
    public static function cambiarEstadoPorcentaje($idPorcentaje, $estadoPorcentaje){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_Porcentaje SET estado_Porcentaje = '$estadoPorcentaje' WHERE id_Porcentaje = '$idPorcentaje'";
        $porcentajes = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
}