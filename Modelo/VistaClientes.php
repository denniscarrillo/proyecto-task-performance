<?php
class Cliente {
    public $idCliente;
    public $nombre;
    public $rtn;
    public $telefono;
    public $correo;
    public $tipoCliente;
    
  //Método para obtener todos los clientes que existen.
    public static function obtenerTodosLosClientes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query="SELECT CODCLIENTE, NOMBRECLIENTE, CIF, TELEFONO1, DIRECCION1 FROM View_Clientes;"; 
        $listaClientes = sqlsrv_query($consulta, $query);
        $clientes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaClientes, SQLSRV_FETCH_ASSOC)){
            $clientes [] = [
                'codCliente' => $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'telefono'=> $fila["TELEFONO1"],
                'direccion' => $fila["DIRECCION1"]             
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $clientes;
    }

}#Fin de la clase

