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
        $listaUsuarios = $consulta->query("SELECT * FROM tbl_usuario");

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
        $rtn = $nuevoUsuario->rtn;
        $usuario =$nuevoUsuario->usuario;
        $nombre = $nuevoUsuario->nombre;
        $estado = $nuevoUsuario->estado;
        $contrasenia =$nuevoUsuario->contrasenia;
        $correo =$nuevoUsuario->correo;
        $telefono = $nuevoUsuario->telefono;
        $direccion =$nuevoUsuario->direccion;
    
        $nuevoUsuario = $consulta->query("INSERT INTO tlb_usuarios (rtn_Usuario, usuario, nombre_Usuario, estado_Usuario, Contrasenia, correo_Electronico, telefono, direccion) VALUES('$rtn', '$usuario','$nombre', '$estado', '$contrasenia',
        '$correo','$telefono','$direccion')");
        mysqli_close($consulta); #Cerramos la conexión.
    }

    public static function buscarUsuario($userName, $userPassword){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $usuario = $consulta->query("SELECT * FROM tbl_usuario WHERE usuario = '$userName' and contrasenia = '$userPassword' ");
        $existe = $usuario->num_rows;
        mysqli_close($consulta); #Cerramos la conexión.
        return $existe;
    }
    //Obtener intentos permitidos de la tabla parámetro
    public static function intentosValidos(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $resultado = $conexion->query("SELECT Valor  FROM tbl_parametro WHERE Parametro = 'ADMIN INTENTOS'");
        //Obtenemos el valor de Intentos que viene de la DB
        $fila = $resultado->fetch_assoc();
        $intentos = $fila["Valor"]; 
        mysqli_close($conexion); #Cerramos la conexión.
        return $intentos;
    }
    //Obtener número de intentos falllidos del usuario en el login.
    public static function intentosInvalidos($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $resultado = $conexion->query("SELECT intentos_Fallidos FROM tbl_usuario WHERE usuario = '$usuario'");
        //Obtenemos el valor de Intentos que viene de la DB
        $fila = $resultado->fetch_array(MYSQLI_NUM);
        $fallidos = $fila[0]; 
        mysqli_close($conexion); #Cerramos la conexión.
        return $fallidos;
    }
    public static function bloquearUsuario($intentosMax, $intentosFallidos, $user){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $estadoUser = false;
        if($intentosFallidos > $intentosMax){
            $nuevoEstado = "Bloqueado";
            $estadoUser = $conexion->query("UPDATE `tbl_usuario` SET `estado_Usuario`= '$nuevoEstado' WHERE `usuario` = '$user'");
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $estadoUser;
    }
    public static function aumentarIntentosFallidos($usuario, $intentosFallidos){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $incremento = ($intentosFallidos + 1);
        $conexion->query("UPDATE `tbl_usuario` SET `intentos_Fallidos` = '$incremento' WHERE `usuario` = '$usuario'");
        mysqli_close($conexion); #Cerramos la conexión.
        return $incremento;
    }

} #Fin de la clase