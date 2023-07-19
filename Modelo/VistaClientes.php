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
            $consulta->query("SELECT c.id_Cliente, c.nombre_Cliente, c.rtn_Cliente,c.telefono,c.correo,
                t.descripcion
                FROM tbl_vista_Cliente AS c
                INNER JOIN tbl_vista_TipoCliente AS t ON c.id_TipoCliente = t.id_TipoCliente;");
        $clientes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaClientes->fetch_assoc()){
            $clientes [] = [
                'idCliente' => $fila["id_Cliente"],
                'nombre'=> $fila["nombre_Cliente"],
                'rtn' => $fila["rtn_Cliente"],
                'telefono'=> $fila["telefono"],
                'correo' => $fila["correo"],
                'descripcion' => $fila["descripcion"]               
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $clientes;
    }

}#Fin de la clase

