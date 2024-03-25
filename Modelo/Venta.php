<?php
class Venta {
    public $numFactura;
    public $rtnCliente;
    public $totalVenta;
    public $creadoPor;
    public $fechaCreacion;
    
  //Método para obtener todas las ventas que existen.
    public static function obtenertodaslasventas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        
        $query = "SELECT  ROW_NUMBER() OVER(ORDER BY vt.num_Factura ASC) AS Num, vt.num_Factura, cc.nombre_Cliente, vt.rtn_Cliente, vt.total_Venta, vt.Creado_Por, vt.Fecha_Creacion FROM tbl_FacturasVenta vt
        INNER JOIN tbl_CarteraCliente cc ON vt.rtn_Cliente = cc.rtn_Cliente;";
        $listaVentas = sqlsrv_query($consulta, $query);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaVentas, SQLSRV_FETCH_ASSOC)){
            $ventas [] = [
                'item' => $fila["Num"],
                'numFactura' => $fila["num_Factura"],
                'nombreCliente'=> $fila["nombre_Cliente"],
                'rtnCliente' => $fila["rtn_Cliente"],    
                'totalVenta' => $fila["total_Venta"],
                'creadoPor' => $fila["Creado_Por"],
                'fechaCreacion' => $fila["Fecha_Creacion"] 
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $ventas;
    }
    public static function crearNuevaVenta($nuevaVenta){
        $conn = new Conexion();
        $consulta = $conn -> abrirConexionDB();
        $rtnCliente = $nuevaVenta->rtnCliente;
        $totalVenta = $nuevaVenta ->totalVenta;
        $creadoPor = $nuevaVenta->creadoPor;
        $query = "INSERT INTO tbl_FacturasVenta (rtn_Cliente, total_Venta, Creado_Por, Fecha_Creacion) 
        VALUES ('$rtnCliente', '$totalVenta', '$creadoPor', GETDATE());";
        sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta);
    }

    public static function validarClienteExistenteCarteraCliente($rtn){
        $estadoCliente = false;
        try{
            $datosCliente = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT nombre_Cliente FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtn'";
            $consulta = sqlsrv_query($abrirConexion, $selectCliente);
            if(sqlsrv_has_rows($consulta)){
                while($fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
                    $datosCliente = [
                        'nombre' => $fila['nombre_Cliente']
                    ];
                }
                sqlsrv_close($abrirConexion); //Cerrar conexion
                return $datosCliente;
            } else {
               return $estadoCliente;
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
    }

    public static function eliminarVenta($numFactura){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_FacturasVenta WHERE num_Factura = '$numFactura';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
            if(!$estadoEliminado) {
                return false;
            }
            sqlsrv_close($conexion); //Cerrar conexion
            return true;
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
    }
    public static function obtenerVentasPorFechas($fechaDesde, $fechaHasta){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $select = "SELECT vt.num_Factura, cc.nombre_Cliente, vt.rtn_Cliente, vt.total_Venta, vt.Creado_Por, vt.Fecha_Creacion FROM tbl_FacturasVenta vt
        INNER JOIN tbl_CarteraCliente cc ON vt.rtn_Cliente = cc.rtn_Cliente
                    WHERE vt.Fecha_Creacion BETWEEN '$fechaDesde 00:00:00:00' AND '$fechaHasta 23:59:59:59';";
        $query = $select;
        $listaVentas = sqlsrv_query($conexion, $query);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaVentas, SQLSRV_FETCH_ASSOC)){
            $ventas [] = [
                'numFactura' => $fila["num_Factura"],
                'nombreCliente'=> $fila["nombre_Cliente"],
                'rtnCliente' => $fila["rtn_Cliente"],    
                'totalVenta' => $fila["total_Venta"],
                'creadoPor' => $fila["Creado_Por"],
                'fechaCreacion' => $fila["Fecha_Creacion"]       
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $ventas;
    }

    //obtener el id de la venta
    public static function obtenerIdVenta($numFactura){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTOS, v.TOTALNETO
        FROM View_Clientes AS c
        INNER JOIN View_FACTURASVENTA AS v ON c.CODCLIENTE = v.CODCLIENTE WHERE NUMFACTURA = '$numFactura';";
        $consulta = sqlsrv_query($conexion, $query);
        $idVenta = array();
        While($fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
            $idVenta [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente'=> $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'fechaEmision' => $fila["FECHA"],
                'totalBruto'=> $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTOS"],   
                'totalVenta' => $fila["TOTALNETO"]    
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $idVenta;
    }

    //Método para obtener todas las ventas que existen.
    public static function obtenerlasventasPDF($buscar){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.        
        $query = "SELECT vt.num_Factura, cc.nombre_Cliente, vt.rtn_Cliente, vt.total_Venta, vt.Creado_Por, vt.Fecha_Creacion FROM tbl_FacturasVenta vt
        INNER JOIN tbl_CarteraCliente cc ON vt.rtn_Cliente = cc.rtn_Cliente
		WHERE CONCAT(vt.num_Factura, cc.nombre_Cliente, vt.rtn_Cliente, vt.total_Venta, vt.Creado_Por, CONVERT(NVARCHAR, vt.Fecha_Creacion , 23)) 
        LIKE '%' + '$buscar' + '%' ORDER BY vt.num_Factura;";
        $listaVentas = sqlsrv_query($consulta, $query);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaVentas, SQLSRV_FETCH_ASSOC)){
            $ventas [] = [
                'numFactura' => $fila["num_Factura"],
                'nombreCliente'=> $fila["nombre_Cliente"],
                'rtnCliente' => $fila["rtn_Cliente"],
                'totalVenta'=> $fila["total_Venta"],
                'CreadoPor' => $fila["Creado_Por"],
                'FechaCreacion' => $fila["Fecha_Creacion"]  
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $ventas;
    }

}#Fin de la clase
