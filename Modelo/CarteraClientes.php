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
    date_default_timezone_set('America/Tegucigalpa');
    $fechaCreacion = date("Y-m-d");
    $query = "INSERT INTO tbl_CarteraCliente(nombre_Cliente,rtn_Cliente,telefono,
                                            correo,direccion,estadoContacto,Creado_Por,Fecha_Creacion )
                   VALUES ('$nombre', '$rtn', '$telefono', '$correo','$direccion','$estadoContacto','$CreadoPor','$fechaCreacion');";
    $nuevoCliente = sqlsrv_query($consulta, $query);
    sqlsrv_close($consulta); #Cerramos la conexión.
    return $nuevoCliente;
    }

    public static function editarCliente($Cliente){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $update = "UPDATE tbl_carteraCliente SET telefono='$Cliente->telefono', correo='$Cliente->correo', direccion='$Cliente->direccion', 
                        estadoContacto = '$Cliente->estadoContacto', Modificado_Por = '$Cliente->modificadoPor', Fecha_Modificacion = GETDATE()
                        WHERE rtn_Cliente = '$Cliente->rtn'";
            sqlsrv_query($abrirConexion, $update);
            sqlsrv_close($abrirConexion); //Cerrar conexion
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
    }
// funcion que me muestre si el rtn del cliente existe tanto en cartera de clientes como en la tabla view de clientes
    public static function rtnExistente($rtn){
        $existeRtn = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT rtn_Cliente FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtn'";
        $rtnCliente = sqlsrv_query($conexion, $query);
        // $query2 = "SELECT CIF FROM View_Clientes WHERE (CIF = '$rtn' AND CIF IS NOT NULL AND CIF != '')
        //    OR (CIF IS NOT NULL AND CIF != '' AND '$rtn' IS NULL)";
        // $rtnCliente2 = sqlsrv_query($conexion, $query2);
        $existe = sqlsrv_has_rows($rtnCliente);
        //$existe2 = sqlsrv_has_rows($rtnCliente2);
        //|| $existe2
        if($existe){
            $existeRtn = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existeRtn;
    }
    
    public static function eliminarCliente($rtnCliente){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $eliminarCliente = "DELETE FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtnCliente'";
            $estadoEliminado = sqlsrv_query($abrirConexion, $eliminarCliente);
            if(!$estadoEliminado) {
                return false;
            }
            sqlsrv_close($abrirConexion); //Cerrar conexion
            return true;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
    }

    //Método para obtener todos los clientes que existen.
    public static function obtenerCarteraClientesPDF($buscar){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $obtenerCarteraCliente = "SELECT id_CarteraCliente, nombre_Cliente, rtn_Cliente, telefono, correo, 
        direccion, estadoContacto FROM tbl_CarteraCliente
        WHERE CONCAT(id_CarteraCliente, nombre_Cliente, rtn_Cliente, telefono, correo, direccion, estadoContacto) LIKE '%' + '$buscar' + '%';";
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
}#Fin de la clase