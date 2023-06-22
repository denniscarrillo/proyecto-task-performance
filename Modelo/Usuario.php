<?php

// require('../db/ConexionDB.php');

class Usuario {
    // public $idUsuario;
    public $rtn;
    public $usuario;
    public $nombre;
    public $estado;
    public $contrasenia;
    #private $fechaUltimaConexion;
    #private $preguntasContestadas;
    #private $fechaPrimerIngreso;
    public $correo;
    public $telefono;
    public $direccion;
    #private $idRol;
    #private $idCargo;
    #private $creadoPor;
    #private $reseteoClave;

    public static function obtenerUsuarios(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaUsuarios = $consulta->query("SELECT*FROM tbl_Usuario");

        $usuarios = array();
        $i = 0;

        while($fila = $listaUsuarios->fetch_assoc()){
            $usuarios[$i][0] = $fila["id_usuario"];
            $usuarios[$i][1] = $fila["usuario"]; 
            $usuarios[$i][2] = $fila["nombre"];
            $usuarios[$i][3] = $fila["contrasenia"];    
            $i++;
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $usuarios;
    }

    // public static function ingresarUsuarios($idUsuario, $rtn, $usuario, $nombre, $estado, $contrasenia,$correo,$telefono,$direccion){
    //     $conn = new Conexion();
    //     $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
    //     $nuevoUsuario = $consulta->query("INSERT INTO tbl_Usuario (id_usuario, rtn_Usuario, usuario, nombre_Usuario, estado_Usuario, Contrasenia, 
    //     correo_Electronico, telefono, direccion) VALUES('$idUsuario', '$rtn', '$usuario', '$nombre', '$estado', '$contrasenia','$correo','$telefono','$direccion')");
    //     mysqli_close($consulta); #Cerramos la conexión.
    // }

    public function ingresarUsuarios($nuevoUsuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        // $idUsuario = $nuevoUsuario->idUsuario;
        $usuario =$nuevoUsuario->usuario;
        $nombre = $nuevoUsuario->nombre;
        $estado = $nuevoUsuario->estado;
        $contrasenia =$nuevoUsuario->contrasenia;
        $correo =$nuevoUsuario->correo;
    
        $nuevoUsuario = $consulta->query("INSERT INTO tbl_Usuario (usuario, nombre_Usuario, estado_Usuario, Contrasenia, correo_Electronico) VALUES('$usuario','$nombre', '$estado', '$contrasenia',
        '$correo')");
        
        // $nuevoUsuario = $consulta->query("INSERT INTO tbl_Usuario VALUES($nuevoUsuario->$idUsuario, '$nuevoUsuario->$rtn', '$nuevoUsuario->$usuario', 
        // '$nuevoUsuario->$nombre', '$nuevoUsuario->$estado', '$nuevoUsuario->$contrasenia','$nuevoUsuario->$correo','$nuevoUsuario->$telefono','$nuevoUsuario->$direccion')");
        
        // $nuevoUsuario = $consulta->query("INSERT INTO tbl_Usuario VALUES(". $nuevoUsuario->$idUsuario.", '". $nuevoUsuario->$rtn ."', '". $nuevoUsuario->$usuario."', 
        // '". $nuevoUsuario->$nombre. "', '".$nuevoUsuario->$estado. "', '". $nuevoUsuario->$contrasenia. "','". $nuevoUsuario->$correo. "','" .$nuevoUsuario->$telefono. "','". $nuevoUsuario->$direccion. "')");
        mysqli_close($consulta); #Cerramos la conexión.
    }

    public static function buscarUsuario($userName, $userPassword){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $usuario = $consulta->query("SELECT * FROM tbl_Usuario WHERE usuario = '$userName' and contrasenia = '$userPassword' ");
        $existe = $usuario->num_rows;
        mysqli_close($consulta); #Cerramos la conexión.
        return $existe;
    }

    public function actualizarUsuario($idUsuario){
        
    }

    public function EliminarUsuario($idUsuario){
        
    }
} #Fin de la clase
?>