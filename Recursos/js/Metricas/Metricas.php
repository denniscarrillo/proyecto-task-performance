<?php
class Metricas{
    public $idMetrica;
    public $idEstadoAvance;
    public $meta;
    public $creadoPor;
        
  //Método para obtener todos los clientes que existen.
    public static function obtenerMetricas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaMetricas = 
            $consulta->query("SELECT m.id_Metrica,e.descripcion,m.meta FROM tbl_metrica as m
            inner join tbl_estadoavance AS e ON m.id_EstadoAvance = e.id_EstadoAvance;");
        $Metricas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaMetricas->fetch_assoc()){
            $Metricas [] = [
                'idMetrica' => $fila["id_Metrica"],
                'descripcion'=> $fila["descripcion"],
                'meta' => $fila["meta"]         
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $Metricas;
    }


    //Método para crear nueva Metrica
    public static function registroNuevaMetrica($nuevaMetrica){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
    $idEstadoAvance = $nuevaMetrica->idEstadoAvance;
    $meta = $nuevaMetrica->meta;
    $nuevaMetrica = $consulta->query("INSERT INTO tbl_metrica(id_EstadoAvance,meta)
                     VALUES('$idEstadoAvance','$meta');");
    mysqli_close($consulta); #Cerramos la conexión.
    return $nuevaMetrica;
    }

    public static function obtenerEstadoAvance(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $obtenerEstado = $conexion->query("SELECT id_EstadoAvance,descripcion FROM tbl_estadoavance;");
        $estadoAvance = array();
        while($fila = $obtenerEstado->fetch_assoc()){
            $estadoAvance [] = [
                'idEstadoAvance' => $fila["id_EstadoAvance"],
                'descripcion' => $fila["descripcion"]
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $estadoAvance;
    }



    // public static function editarCliente($nuevoCliente){
    //     $conn = new Conexion();
    //     $conexion = $conn->abrirConexionDB();
    //     $idcarteraCliente = $nuevoCliente->idcarteraCliente;
    //     $nombre =$nuevoCliente->nombre;
    //     $rtn = $nuevoCliente->rtn;
    //     $telefono =$nuevoCliente->telefono;
    //     $correo = $nuevoCliente->correo;
    //     $idestadoContacto = $nuevoCliente->idestadoContacto;
    //     $nuevoCliente = $conexion->query("UPDATE tbl_carteracliente SET nombre_cliente='$nombre', rtn_Cliente='$rtn',telefono='$telefono',correo='$correo', id_estadoContacto='$idestadoContacto' WHERE id_CarteraCliente='$idcarteraCliente';");
    //     mysqli_close($conexion); #Cerramos la conexión.
    // }

    // public static function eliminarCliente($nombre){
    //     $conn = new Conexion();
    //     $conexion = $conn->abrirConexionDB();
    //     $consultaidCliente= $conexion->query("SELECT id_CarteraCliente FROM tbl_CarteraCliente WHERE nombre_Cliente = '$nombre'");
    //     $fila = $consultaidCliente->fetch_assoc();
    //     $idcarteraCliente = $fila['id_CarteraCliente'];
    //     //Eliminamos el cliente
    //     $estadoEliminado = $conexion->query("DELETE FROM tbl_CarteraCliente WHERE id_CarteraCliente = $idcarteraCliente;");
    //     mysqli_close($conexion); #Cerramos la conexión.
    //     return $estadoEliminado;
    // }

    

}#Fin de la clase
