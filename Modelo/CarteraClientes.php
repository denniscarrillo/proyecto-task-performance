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
        $obtenerCarteraCliente = "SELECT id_CarteraCliente, nombre_Cliente, rtn_Cliente, telefono, correo, direccion, estadoContacto
        FROM tbl_CarteraCliente;";
        $resultado = sqlsrv_query($consulta, $obtenerCarteraCliente);
        $carteraCliente = array();
        while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
            $carteraCliente [] = [
                'idcarteraCliente' => $fila["id_CarteraCliente"],
                'nombre' => $fila["nombre_Cliente"],
                'rtn' => $fila["rtn_Cliente"],
                'telefono' => $fila["telefono"],
                'correo' => $fila["correo"],
                'direccion' => $fila["direccion"],
                'estadoContacto' => $fila["estadoContacto"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
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
    $CreadoPor = $nuevoCliente->CreadoPor;
    $fechaCreacion = $nuevoCliente->fechaCreacion;
    $query = "INSERT INTO tbl_CarteraCliente(nombre_Cliente,rtn_Cliente,telefono,
                                            correo,direccion,estadoContacto,Creado_Por,Fecha_Creacion )
                   VALUES ('$nombre', '$rtn', '$telefono', '$correo','$direccion','$estadoContacto','$CreadoPor','$fechaCreacion');";
    $nuevoCliente = sqlsrv_query($consulta, $query);
    sqlsrv_close($consulta); #Cerramos la conexión.
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
            $estadoContacto=$nuevoCliente->estadoContacto;
            $modificadoPor = $nuevoCliente->modificadoPor;
            $fechaModificacion = $nuevoCliente->fechaModificacion;
            $update = "UPDATE tbl_carteracliente SET nombre_Cliente='$nombre', rtn_Cliente='$rtn', telefono='$telefono',
            correo='$correo', direccion='$direccion', estadoContacto = '$estadoContacto', Modificado_Por = '$modificadoPor', Fecha_Modificacion = '$fechaModificacion' WHERE id_CarteraCliente='$id' ";
            $nuevoCliente = sqlsrv_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
}#Fin de la clase

