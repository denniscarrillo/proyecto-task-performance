<?php
class CarteraClientes{
    public $idcarteraCliente;
    public $nombre;
    public $rtn;
    public $telefono;
    public $correo;
    public $direccion;
    public $estadoContacto;
    public $CreadoPor;
    public $fechaCreacion;
    public $modificadoPor;
    public $fechaModificacion;
        
  //Método para obtener todos los clientes que existen.
    public static function obtenerCarteraClientes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $obtenerCarteraCliente = $consulta->query("SELECT id_CarteraCliente, nombre_Cliente, rtn_Cliente, telefono, correo, direccion, estado_Contacto
        FROM tbl_CarteraCliente;");
        $carteraCliente = array();
        while($fila = $obtenerCarteraCliente->fetch_assoc()){
            $carteraCliente [] = [
                'id' => $fila["id_CarteraCliente"],
                'nombre' => $fila["nombre_Cliente"],
                'rtn' => $fila["rtn_Cliente"],
                'telefono' => $fila["telefono"],
                'correo' => $fila["correo"],
                'direccion' => $fila["direccion"],
                'estado' => $fila["estado_Contacto"]
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $carteraCliente;
    }
    //Método para crear nuevo cliente
    public static function registroNuevoCliente($nuevoCliente){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
    $nombre = $nuevoCliente->nombre;
    $rtn = $nuevoCliente->rtn;
    $telefono = $nuevoCliente->telefono;
    $correo = $nuevoCliente->correo;
    $direccion = $nuevoCliente->direccion;
    $estadoContacto = $nuevoCliente->estadoContacto;
    $nuevoCliente = $consulta->query("INSERT INTO tbl_CarteraCliente(nombre_Cliente,rtn_Cliente,telefono,correo,direccion,estado_Contacto)
                   VALUES ('$nombre', '$rtn', '$telefono', '$correo','$direccion','$estadoContacto');");
    mysqli_close($consulta); #Cerramos la conexión.
    return $nuevoCliente;
    }

    public static function editarCliente($nuevoCliente){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $id=$nuevoCliente->idcarteraCliente;
            $nombre=$nuevoCliente->nombre;
            $rtn=$nuevoCliente->rtn;
            $telefono=$nuevoCliente->telefono;
            $correo=$nuevoCliente->correo;
            $direccion=$nuevoCliente->direccion;
            $update = "UPDATE tbl_carteracliente SET nombre_Cliente='$nombre', rtn_Cliente='$rtn', telefono='$telefono',
            correo='$correo', direccion='$direccion' WHERE id_CarteraCliente='$id' ";
            $ejecutar_update = mysqli_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
}#Fin de la clase

