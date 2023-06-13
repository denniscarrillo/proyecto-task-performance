<?php

// require('../db/ConexionDB.php');

class Usuario {
    private $idUsuario;
    #private $rtn;
    private $usuario;
    private $nombre;
    #private $estado;
    private $contrasenia;
    #private $fechaUltimaConexion;
    #private $preguntasContestadas;
    #private $fechaPrimerIngreso;
    #private $correo;
    #private $telefono;
    #private $direccion;
    #private $idRol;
    #private $idCargo;
    #private $creadoPor;
    #private $reseteoClave;

    public static function obtenerUsuarios(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaUsuarios = $consulta->query("SELECT*FROM tlb_usuarios");

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

    public static function buscarUsuario($userName, $userPassword){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $usuario = $consulta->query("SELECT * FROM tlb_usuarios WHERE usuario = '$userName' and contrasenia = '$userPassword' ");
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