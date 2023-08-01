<?php

class Comision 
{
    public $idComision;
    public $idVenta;
    public $idPorcentaje;
    public $comisionTotal;

    public static function obtenerTodasLasComisiones(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaComision = 
            $consulta->query("SELECT co.id_Comision, co.id_Venta, v.TOTALNETO, po.valor_Porcentaje, co.comision_TotalVenta
            FROM tbl_comision AS co
            INNER JOIN view_facturasventa AS v ON co.id_Venta = v.NUMFACTURA
            INNER JOIN  tbl_porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje;");
        $Comision = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaComision->fetch_assoc()){
            $Comision [] = [
                'idComision' => $fila["id_Comision"],
                'factura' => $fila["id_Venta"],
                'totalVenta'=> $fila["TOTALNETO"],
                'porcentaje' => $fila["valor_Porcentaje"],
                'comisionTotal' => $fila["comision_TotalVenta"]
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $Comision;
    }
    public static function registroNuevaComision($nuevaComision){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $idVenta = $nuevaComision->idVenta;
        $idPorcentaje = $nuevaComision->idPorcentaje;
        $comisionTotal = $nuevaComision->comisionTotal;
        
        $nuevaComisionQuery = "INSERT INTO `tbl_comision` (`id_Venta`, `id_Porcentaje`, 
        `comision_TotalVenta`, `Creado_Por`,`Fecha_Creacion`, `Modificado_Por`, `Fecha_Modificacion`)  
        VALUES ('$idVenta','$idPorcentaje','$comisionTotal', NULL, NULL, NULL, NULL)";
    
        // Ejecutamos la consulta y comprobamos si fue exitosa
        $resultado = $consulta->query($nuevaComisionQuery);
        if (!$resultado) {
            // Si la consulta falla, manejar el error adecuadamente (mostrar mensaje de error o log).
            // También es importante evitar la inyección de SQL en esta consulta.
        }
    
        mysqli_close($consulta); #Cerramos la conexión.
        return $resultado;
 
    }

    public static function obtenerPorcentajesComision(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaPorcentajes = $conexion->query("SELECT id_Porcentaje, valor_Porcentaje FROM tbl_porcentaje WHERE estado_Porcentaje = 'Activo'");
        $porcentajes = array();
        while ($fila = $listaPorcentajes->fetch_assoc()) {
            $porcentajes[] = [
            'idPorcentaje' => $fila['id_Porcentaje'],
            'porcentaje' => $fila['valor_Porcentaje']
            ];
        }
    
        mysqli_close($conexion); #Cerramos la conexión.
        return $porcentajes;
    }
}


    

#Fin de la clase