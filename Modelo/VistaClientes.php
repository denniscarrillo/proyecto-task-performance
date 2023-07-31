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
        $listaClientes = 
            $consulta->query("SELECT CODCLIENTE, NOMBRECLIENTE, CIF, TELEFONO1, DIRECCION1 FROM View_Clientes;");
        $clientes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaClientes->fetch_assoc()){
            $clientes [] = [
                'codCliente' => $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'telefono'=> $fila["TELEFONO1"],
                'direccion' => $fila["DIRECCION1"]             
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $clientes;
    }

}#Fin de la clase

