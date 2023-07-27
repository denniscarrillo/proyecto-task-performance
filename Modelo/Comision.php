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
            $consulta->query("SELECT co.id_Comision, v.total_Venta, po.valor_Porcentaje,
            co.comision_TotalVenta
            FROM tbl_comision AS co
            INNER JOIN tbl_vista_venta AS v ON co.id_Venta = v.id_Venta
            INNER JOIN  tbl_porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje;
            ");
        $Comision = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaComision->fetch_assoc()){
            $Comision [] = [
                'IdComision' => $fila["id_Comision"],
                'Venta' => $fila["total_Venta"],
                'Porcentaje'=> $fila["valor_Porcentaje"],
                'ComisionTotal' => $fila["comision_TotalVenta"],
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

    public static function obtenerComision($obtenerVenta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaVentas = $consulta->query("SELECT id_Venta FROM tbl_vista_venta ORDER BY id_Venta desc");
        $venta = array();
    
        // Aquí falta recorrer los resultados y almacenarlos en el array $venta
        while ($fila = $listaVentas->fetch_assoc()) {
            $venta[] = $fila['id_Venta'];
        }
    
        mysqli_close($consulta); #Cerramos la conexión.
        return $venta;
    }
}


    

#Fin de la clase