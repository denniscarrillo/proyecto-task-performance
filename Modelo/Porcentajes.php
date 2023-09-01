<?php

class Porcentajes {
    public $idPorcentaje;
    public $valorPorcentaje;
    public $descripcionPorcentaje;
    public $estadoPorcentaje;

    public $CreadoPor;

    //Método para obtener todos los usuarios que existen.
    public static function obtenerPorcentajes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Porcentaje,valor_Porcentaje,descripcion,estado_Porcentaje 
            FROM tbl_porcentaje;";
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
        $query = "INSERT INTO tbl_Porcentaje(valor_Porcentaje,descripcion,estado_Porcentaje)
                       VALUES ('$valorPorcentaje', '$descripcionPorcentaje', '$estadoPorcentaje');";        
        $nuevoPorcentaje = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $nuevoPorcentaje;
    }

    public static function editarPorcentaje($nuevoPorcentaje){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idPorcentaje = $nuevoPorcentaje->idPorcentaje;
        $valorPorcentaje = $nuevoPorcentaje->valorPorcentaje;
        $descripcionPorcentaje =$nuevoPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $nuevoPorcentaje->estadoPorcentaje;
        $query = "UPDATE tbl_porcentaje SET valor_Porcentaje='$valorPorcentaje', descripcion='$descripcionPorcentaje',estado_Porcentaje='$estadoPorcentaje' WHERE id_Porcentaje='$idPorcentaje';";
        $nuevoPorcentaje = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }


}