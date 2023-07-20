<?php
class CarteraClientes{
    public $idcarteraCliente;
    public $nombre;
    public $rtn;
    public $telefono;
    public $correo;
    public $estadoContacto;
    public $CreadoPor;
    public $fechaCreacion;
    public $modificadoPor;
    public $fechaModificacion;
        
  //Método para obtener todos los clientes que existen.
    public static function obtenerCarteraClientes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaCarteraClientes = 
            $consulta->query("SELECT id_CarteraCliente,nombre_Cliente, rtn_Cliente,telefono,correo,
            estado_Contacto
            FROM tbl_CarteraCliente;");
        $carteraClientes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaCarteraClientes->fetch_assoc()){
            $carteraClientes [] = [
                'idcarteraCliente' => $fila["id_CarteraCliente"],
                'nombre'=> $fila["nombre_Cliente"],
                'rtn' => $fila["rtn_Cliente"],
                'telefono'=> $fila["telefono"],
                'correo' => $fila["correo"],
                'estadoContacto' => $fila["estado_Contacto"]               
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $carteraClientes;
    }


    //Método para crear nuevo usuario desde Autoregistro.
    public static function registroNuevoCliente($nuevoCliente){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
    $nombre =$nuevoCliente->nombre;
    $rtn = $nuevoCliente->rtn;
    $telefono = $nuevoCliente->telefono;
    $correo = $nuevoCliente->correo;
    $estadoContacto = $nuevoCliente->estadoContacto;
    $nuevoCliente = $consulta->query("INSERT INTO tbl_CarteraCliente (nombre_Cliente,rtn_Cliente,telefono,correo,estado_Contacto)
                   VALUES ('$nombre', '$rtn', '$telefono', '$correo','$estadoContacto')");
    mysqli_close($consulta); #Cerramos la conexión.
    return $nuevoCliente;
    }

}#Fin de la clase

