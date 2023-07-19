<?php
class Venta {
    public $idVenta;
    public $fehaEmision;
    public $idCliente;
    public $idUsuario;
    public $totalDescuento;
    public $subtotal;
    public $importeExonerado;
    public $importeExcento;
    public $isv;
    public $totalImpuesto;
    public $totalVenta;
    public $estadoVenta;
    
  //Método para obtener todas las ventas que existen.
    public static function obtenertodaslasventas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaVentas = 
            $consulta->query("SELECT v.id_Venta, v.fecha_Emision,c.nombre_cliente,u.nombre_Usuario,v.total_Descuento,
            v.subtotal_Venta,v.total_Impuesto,v.total_Venta,v.estado_Venta 
                FROM tbl_vista_venta AS v
                INNER JOIN tbl_vista_cliente AS c ON v.id_Cliente = c.id_Cliente
                INNER JOIN tbl_ms_usuario AS u ON v.id_Usuario = u.id_Usuario;
                ");
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaVentas->fetch_assoc()){
            $ventas [] = [
                'idventa' => $fila["id_Venta"],
                'fechaEmision' => $fila["fecha_Emision"],
                'nombreCliente'=> $fila["nombre_cliente"],
                'nombreUsuario' => $fila["nombre_Usuario"],
                'totalDescuento'=> $fila["total_Descuento"],
                'subtotalVenta' => $fila["subtotal_Venta"],
                'totalImpuesto' => $fila["total_Impuesto"],     
                'totalVenta' => $fila["total_Venta"],   
                'estadoVenta' => $fila["estado_Venta"]         
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $ventas;
    }

}#Fin de la clase
