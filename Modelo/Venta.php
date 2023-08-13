<?php
class Venta {
    public $numFactura;
    public $CodCliente;
    public $NombreCliente;
    public $Cif;
    public $Fecha;
    public $TotalBruto;
    public $TotalImpuesto;
    public $TotalNeto;
    
  //Método para obtener todas las ventas que existen.
    public static function obtenertodaslasventas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaVentas = 
            $consulta->query("SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTO, v.TOTALNETO
            FROM view_Clientes AS c
            INNER JOIN View_FACTURASVENTA AS v ON c.CODCLIENTE = v.CODCLIENTE;
            ");
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaVentas->fetch_assoc()){
            $ventas [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente' => $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente' => $fila["CIF"],
                'fechaEmision'=> $fila["FECHA"],
                'totalBruto' => $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTO"],     
                'totalNeto' => $fila["TOTALNETO"]    
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $ventas;
    }
    public static function obtenerVentasPorFechas($fechaDesde, $fechaHasta){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $select = "SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTO, v.TOTALNETO
                    FROM view_clientes AS c
                    INNER JOIN View_facturasventa AS v ON c.CODCLIENTE = v.CODCLIENTE
                    WHERE v.FECHA BETWEEN '$fechaDesde' AND '$fechaHasta';";
        $listaVentas =  $conexion->query($select);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaVentas->fetch_assoc()){
            $ventas [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente'=> $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'fechaEmision' => $fila["FECHA"],
                'totalBruto'=> $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTO"],   
                'totalVenta' => $fila["TOTALNETO"]       
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $ventas;
    }

//obtener el id de la venta
    public static function obtenerIdVenta($numFactura){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $consulta = $conexion->query("SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTO, v.TOTALNETO
        FROM View_Clientes AS c
        INNER JOIN View_FACTURASVENTA AS v ON c.CODCLIENTE = v.CODCLIENTE WHERE NUMFACTURA = '$numFactura';");
        $idVenta = array();
        While($fila = $consulta->fetch_assoc()){
            $idVenta [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente'=> $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'fechaEmision' => $fila["FECHA"],
                'totalBruto'=> $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTO"],   
                'totalVenta' => $fila["TOTALNETO"]    
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $idVenta;
    }
    //obtener el id de la venta
    /* public static function obtenerIdVentaPorFecha($numFactura, $fechaEmision){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $consulta = $conexion->query("SELECT id_Venta FROM tbl_facturaventa WHERE num_Factura = '$numFactura' AND fecha_Emision = '$fechaEmision';");
        $fila = $consulta->fetch_assoc();
        $idVenta = $fila['id_Venta'];
        mysqli_close($conexion); #Cerramos la conexión.
        return $idVenta;
    }
    //obtener el id de la venta
    public static function obtenerIdVentaPorFechaCliente($numFactura, $fechaEmision, $rtnCliente){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $consulta = $conexion->query("SELECT id_Venta FROM tbl_facturaventa WHERE num_Factura = '$numFactura' AND fecha_Emision = '$fechaEmision' AND RTN_Cliente = '$rtnCliente';");
        $fila = $consulta->fetch_assoc();
        $idVenta = $fila['id_Venta'];
        mysqli_close($conexion); #Cerramos la conexión.
        return $idVenta;
    } */
}#Fin de la clase
