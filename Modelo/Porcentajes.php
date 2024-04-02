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
        $query = "SELECT ROW_NUMBER() OVER(ORDER BY id_Porcentaje ASC) AS Num, id_Porcentaje,valor_Porcentaje, descripcion, estado_Porcentaje
        FROM tbl_Porcentaje;";
        $listaPorcentajes = sqlsrv_query($consulta, $query);
        $Porcent = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaPorcentajes, SQLSRV_FETCH_ASSOC)){
            $Porcent [] = [
                'item' => $fila["Num"],
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
    public static function registroPorcentaje($nuevoPorcentaje){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
        $valorPorcentaje = $nuevoPorcentaje->valorPorcentaje;
        $descripcionPorcentaje = $nuevoPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $nuevoPorcentaje->estadoPorcentaje;
        $CreadoPor = $nuevoPorcentaje->CreadoPor;
        // date_default_timezone_set('America/Tegucigalpa');
        // $FechaCreacion = date("Y-m-d");
        $query = "INSERT INTO tbl_Porcentaje(valor_Porcentaje,descripcion,estado_Porcentaje, Creado_Por, Fecha_Creacion)
                       VALUES ('$valorPorcentaje', '$descripcionPorcentaje', '$estadoPorcentaje', '$CreadoPor', GETDATE());";        
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
        $idPorcentaje = $nuevoPorcentaje->idPorcentaje;
        // $valorPorcentaje = $nuevoPorcentaje->valorPorcentaje;
        // $descripcionPorcentaje =$nuevoPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $nuevoPorcentaje->estadoPorcentaje;
        $ModificadoPor = $nuevoPorcentaje->ModificadoPor;
        // date_default_timezone_set('America/Tegucigalpa'); 
        // $FechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_Porcentaje SET estado_Porcentaje ='$estadoPorcentaje', Modificado_Por = '$ModificadoPor', 
        Fecha_Modificacion = GETDATE() WHERE id_Porcentaje='$idPorcentaje';";
        $nuevoPorcentaje = sqlsrv_query($conexion, $query);
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
    public static function verificarUtilizacionEnComision($idPorcentaje) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();

        $query = "SELECT COUNT(*) AS total FROM tbl_Comision WHERE id_Porcentaje = '$idPorcentaje';";
        $params = array($idPorcentaje);
        $stmt = sqlsrv_query($conexion, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $totalComisiones = $result['total'];

        sqlsrv_close($conexion);

        return $totalComisiones > 0;
    }

    public static function inactivarPorcentaje($eliminarPorcentaje) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();

        $idPorcentaje = $eliminarPorcentaje->idPorcentaje;
        $estadoPorcentaje = 'INACTIVO';
        $ModificadoPor = $eliminarPorcentaje->ModificadoPor;
        date_default_timezone_set('America/Tegucigalpa'); 
        $FechaModificacion = date("Y-m-d");

        $query = "UPDATE tbl_Porcentaje SET estado_Porcentaje = '$estadoPorcentaje', Modificado_Por = '$ModificadoPor', Fecha_Modificacion = '$FechaModificacion' WHERE id_Porcentaje = '$idPorcentaje';";
        $params = array($estadoPorcentaje, $ModificadoPor, $FechaModificacion, $idPorcentaje);
        $stmt = sqlsrv_query($conexion, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_close($conexion);
    }

    public static function eliminarPorcentaje($eliminarPorcentaje) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();

        $idPorcentaje = $eliminarPorcentaje->idPorcentaje;

        // Aquí puedes realizar un DELETE directamente si estás seguro de que no hay dependencias,
        // o puedes ejecutar otra lógica de eliminación según tus necesidades.

        // Ejemplo de DELETE:
        $query = "DELETE FROM tbl_Porcentaje WHERE id_Porcentaje = '$idPorcentaje';";
        $params = array($idPorcentaje);
        $stmt = sqlsrv_query($conexion, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_close($conexion);
    }
    
    public static function obtenerPorcentajesPdf($buscar){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Porcentaje,valor_Porcentaje, descripcion, estado_Porcentaje
        FROM tbl_Porcentaje 
        WHERE CONCAT(id_Porcentaje,valor_Porcentaje, descripcion, estado_Porcentaje)
        LIKE '%' + '$buscar' + '%'";
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
    public static function verificandoRelaciones($idPorcentaje) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
    
        // Consulta para verificar si el porcentaje tiene relaciones en otras tablas
        $query = "SELECT COUNT(*) AS num_relaciones FROM tbl_Comision WHERE idPorcentaje = '$idPorcentaje'";
        $params = array($idPorcentaje);
        $stmt = sqlsrv_query($conexion, $query, $params);
    
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    
        // Obtener el resultado de la consulta
        $numRelaciones = 0;
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $numRelaciones = $row['num_relaciones'];
        }
    
        // Cerrar la conexión
        sqlsrv_close($conexion);
    
        // Devolver true si tiene relaciones, false si no tiene
        return $numRelaciones > 0;
    }
}