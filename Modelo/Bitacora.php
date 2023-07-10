<?php

    class Bitacora {
        public $idBitacora;
        public $fecha;
        public $idUsuario;
        public $accion;
        public $idObjeto;
        public $descripcion;

public static function bitacoraUsuario(){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB();
    $verUsuario = $consulta->query("SELECT b.id_Usuario, b.Usuario * FROM tbl_MS_Usuario As b
    INNER JOIN tbl_MS_Bitacora AS i ON b.id_Usuario = i.id_Usuario ");

$bitacora = array();
//Recorremos la consulta y obtenemos los registros en un arreglo asociativo
while($fila = $verUsuario->fetch_assoc()){
    $bitacora [] = [
        'IdBitacora' => $fila["id_Bitacora"],
        'idUsuario' => $fila["id_Usuario"],
        'descripcion'=> $fila["Usuario"],
    ];
}
mysqli_close($consulta); #Cerramos la conexión.
return $bitacora;

}
};