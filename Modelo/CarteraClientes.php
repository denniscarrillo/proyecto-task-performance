<?php
class CarteraClientes{
    public $idcarteraCliente;
    public $nombre;
    public $rtn;
    public $telefono;
    public $correo;
    public $idestadoContacto;
    public $CreadoPor;
    public $fechaCreacion;
    public $modificadoPor;
    public $fechaModificacion;
        
  //Método para obtener todos los clientes que existen.
    public static function obtenerCarteraClientes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaCarteraClientes = 
            $consulta->query("SELECT c.id_CarteraCliente,c.nombre_Cliente,c.rtn_Cliente,c.telefono,c.correo,
            e.contacto_Cliente
            FROM tbl_CarteraCliente as c
            INNER JOIN tbl_contactocliente AS e ON c.id_estadoContacto = e.id_estadoContacto;");
        $carteraClientes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaCarteraClientes->fetch_assoc()){
            $carteraClientes [] = [
                'idcarteraCliente' => $fila["id_CarteraCliente"],
                'nombre'=> $fila["nombre_Cliente"],
                'rtn' => $fila["rtn_Cliente"],
                'telefono'=> $fila["telefono"],
                'correo' => $fila["correo"],
                'estadoContacto' => $fila["contacto_Cliente"]         
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $carteraClientes;
    }


    //Método para crear nuevo cliente
    public static function registroNuevoCliente($nuevoCliente){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
    $nombre = $nuevoCliente->nombre;
    $rtn = $nuevoCliente->rtn;
    $telefono = $nuevoCliente->telefono;
    $correo = $nuevoCliente->correo;
    $idestadoContacto = $nuevoCliente->idestadoContacto;
    $nuevoCliente = $consulta->query("INSERT INTO tbl_CarteraCliente(nombre_Cliente,rtn_Cliente,telefono,correo,id_estadoContacto)
                   VALUES ('$nombre', '$rtn', '$telefono', '$correo','$idestadoContacto');");
    mysqli_close($consulta); #Cerramos la conexión.
    return $nuevoCliente;
    }

    public static function obtenerContactoCliente(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $obtenerContacto = $conexion->query("SELECT id_estadoContacto, contacto_Cliente FROM tbl_contactocliente;");
        $contactoCliente = array();
        while($fila = $obtenerContacto->fetch_assoc()){
            $contactoCliente [] = [
                'id_estadoContacto' => $fila["id_estadoContacto"],
                'contacto_Cliente' => $fila["contacto_Cliente"]
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $contactoCliente;
    }



     public static function eliminarCliente($nombre){
         $conn = new Conexion();
         $conexion = $conn->abrirConexionDB();
         $consultaId= $conexion->query("SELECT id_CarteraCliente FROM tbl_CarteraCliente WHERE nombre_Cliente = '$nombre'");
         $fila = $consultaId->fetch_assoc();
         $idcarteraCliente = $fila['id_CarteraCliente'];
         //Eliminamos el cliente
         $estadoEliminado = $conexion->query("DELETE FROM tbl_CarteraCliente WHERE id_CarteraCliente = $idcarteraCliente;");
         mysqli_close($conexion); #Cerramos la conexión.
         return $estadoEliminado;
     }

    

}#Fin de la clase

