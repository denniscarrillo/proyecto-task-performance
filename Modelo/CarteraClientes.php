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


    //Método para crear nuevo cliente
    public static function registroNuevoCliente($nuevoCliente){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
    $idcarteraCliente = $nuevoCliente->idcarteraCliente;
    $nombre = $nuevoCliente->nombre;
    $rtn = $nuevoCliente->rtn;
    $telefono = $nuevoCliente->telefono;
    $correo = $nuevoCliente->correo;
    $estadoContacto = $nuevoCliente->estadoContacto;
    $nuevoCliente = $consulta->query("INSERT INTO tbl_CarteraCliente(id_CarteraCliente,nombre_Cliente,rtn_Cliente,telefono,correo,estado_Contacto)
                   VALUES ('$idcarteraCliente','$nombre', '$rtn', '$telefono', '$correo','$estadoContacto');");
    mysqli_close($consulta); #Cerramos la conexión.
    return $nuevoCliente;
    }



    public static function eliminarCliente($nombre){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $consultaId= $conexion->query("SELECT id_CarteraCliente FROM tbl_CarteraCliente WHERE nombre_Cliente = '$nombre'");
        $fila = $consultaIdCliente->fetch_assoc();
        $idcarteraCliente = $fila['id_CarteraCliente'];
        //Eliminamos el cliente
        $estadoEliminado = $conexion->query("DELETE FROM tbl_CarteraCliente WHERE id_CarteraCliente = $idcarteraCliente;");
        mysqli_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }

    public static function obtenerContactoCliente(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $obtenerContacto = $conexion->query("SELECT id_EstadoContacto, descripcion FROM tbl_contactoCliente;");
        $contactoCliente = array();
        while($fila = $obtenerContacto->fetch_assoc()){
            $contactoCliente [] = [
                'id_EstadoContacto' => $fila["id_EstadoContacto"],
                'descripcion' => $fila["descripcion"]
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $contactoCliente;
    }

}#Fin de la clase

