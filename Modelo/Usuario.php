<?php

class Usuario {
    public $idUsuario;
    public $rtn;
    public $usuario;
    public $nombre;
    public $idEstado;
    public $contrasenia;
    public $fechaUltimaConexion;
    public $preguntasContestadas;
    public $IngresoUsuario;
    public $correo;
    public $telefono;
    public $direccion;
    public $idRol;
    public $idCargo;
    public $creadoPor;
    public $reseteoClave;

    //Método para obtener todos los usuarios que existen.
    public static function obtenerTodosLosUsuarios(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaUsuarios = 
            $consulta->query("SELECT u.usuario, u.nombre_Usuario, u.contrasenia, 
                u.correo_Electronico, e.descripcion, r.rol
                FROM tbl_ms_usuario AS u
                INNER JOIN tbl_estado_usuario AS e ON u.id_Estado_Usuario = e.id_Estado_Usuario 
                INNER JOIN tbl_ms_roles AS r ON u.id_Rol = r.id_Rol;
            ");
        $usuarios = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaUsuarios->fetch_assoc()){
            $usuarios [] = [
                'usuario' => $fila["usuario"],
                'nombreUsuario'=> $fila["nombre_Usuario"],
                'contrasenia' => $fila["contrasenia"],
                'correo' => $fila["correo_Electronico"],
                'idEstado' => $fila["descripcion"],
                'idRol' => $fila["rol"]
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $usuarios;
    }
    //Método para crear nuevo usuario desde Autoregistro.
    public static function registroNuevoUsuario($nuevoUsuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $usuario =$nuevoUsuario->usuario;
        $nombre = $nuevoUsuario->nombre;
        $idEstado = $nuevoUsuario->idEstado;
        $contrasenia =$nuevoUsuario->contrasenia;
        $correo =$nuevoUsuario->correo;
        $nuevoUsuario = $consulta->query("INSERT INTO tbl_MS_Usuario (usuario, nombre_Usuario, id_Estado_Usuario, contrasenia, correo_Electronico) 
                        VALUES ('$usuario','$nombre', '$idEstado', '$contrasenia', '$correo')");
        mysqli_close($consulta); #Cerramos la conexión.
    }
    //Hace la búsqueda del usuario en login para saber si es válido
    public static function existeUsuario($userName, $userPassword){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $usuario = $consulta->query("SELECT * FROM tbl_MS_Usuario WHERE usuario = '$userName' and contrasenia = '$userPassword' ");
        $existe = $usuario->num_rows;
        mysqli_close($consulta); #Cerramos la conexión.
        return $existe; //Si se encuentra un usuario válido/existente retorna un entero mayor a 0.
    }
    //Obtener intentos permitidos de la tabla parámetro
    public static function intentosPermitidos(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $resultado = $conexion->query("SELECT valor  FROM tbl_MS_Parametro WHERE parametro = 'ADMIN INTENTOS'");
        //Obtenemos el valor de Intentos que viene de la DB
        $fila = $resultado->fetch_assoc();
        $intentos = $fila["valor"]; 
        mysqli_close($conexion); #Cerramos la conexión.
        return $intentos;
    }
    //Obtener número de intentos falllidos del usuario en el login.
    public static function intentosInvalidos($usuario){
        $intentosFallidos = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $existeUsuario = $conexion->query("SELECT usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'");
        if($existeUsuario){
            $resultado = $conexion->query("SELECT intentos_fallidos FROM tbl_MS_Usuario WHERE usuario = '$usuario'");
            //Obtenemos el valor de Intentos que viene de la DB
            $fila = $resultado->fetch_assoc();
            if(isset($fila["intentos_fallidos"])){
                $intentosFallidos = $fila["intentos_fallidos"]; 
            } 
        } 
        mysqli_close($conexion); #Cerramos la conexión.
        return $intentosFallidos;
    }
    public static function bloquearUsuario($intentosMax, $intentosFallidos, $user){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $estadoUser = false;
        if($intentosFallidos > $intentosMax){
            $nuevoEstado = 4;
            $estadoUser = $conexion->query("UPDATE tbl_MS_Usuario SET `id_Estado_Usuario`= '$nuevoEstado' WHERE `usuario` = '$user'");
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $estadoUser;
    }
    public static function aumentarIntentosFallidos($usuario, $intentosFallidos){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $incremento = 0;
        if($intentosFallidos<=3){
        $incremento = ($intentosFallidos + 1);
        $conexion->query("UPDATE tbl_MS_Usuario SET `intentos_fallidos` = '$incremento' WHERE `usuario` = '$usuario'");
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $incremento;
    }
    //Obtener cantidad de preguntas desde el parámetro.
    public static function parametroPreguntas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $paramPreguntas = $consulta->query("SELECT valor FROM tbl_MS_Parametro WHERE Parametro = 'ADMIN PREGUNTAS'");
        $row = $paramPreguntas->fetch_assoc();
        $cantPreguntas = $row["valor"];
        mysqli_close($consulta); #Cerramos la conexión.
        return $cantPreguntas;
    }
    public static function resetearIntentosFallidos($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $resetear = 0;
        $conexion->query("UPDATE tbl_MS_Usuario SET `intentos_fallidos` = '$resetear' WHERE `usuario` = '$usuario'");
        mysqli_close($conexion); #Cerramos la conexión.
    }
    public static function obtenerEstadoUsuario($usuario){
        $estadoBloqueado = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $consultaEstado = $conexion->query("SELECT id_Estado_Usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'");
        $fila = $consultaEstado->fetch_assoc(); 
        if(isset($fila["id_Estado_Usuario"])){
            $estadoBloqueado = $fila["id_Estado_Usuario"];
        }
        return $estadoBloqueado;
    }
    public static function guardarPreguntas($usuario, $preguntas){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        foreach($preguntas as $pregunta){
            $guardarPregunta = $conexion->query("INSERT INTO tbl_ms_preguntas (pregunta, Creado_Por) VALUES ('$pregunta','$usuario');");
        }
    }
} #Fin de la clase
