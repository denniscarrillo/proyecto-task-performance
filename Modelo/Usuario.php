<?php

class Usuario {
    public $idUsuario;
    public $rtn;
    public $usuario;
    public $nombre;
    public $idEstado;
    public $contrasenia;
    public $intentosFallidos;
    public $fechaUltimaConexion;
    public $preguntasContestadas;
    public $IngresoUsuario;
    public $correo;
    public $telefono;
    public $direccion;
    public $idRol;
    public $intentosRespuestas;
    public $idCargo;
    public $creadoPor;
    public $fechaCreacion;
    public $reseteoClave;
    public $modificadoPor;
    public $fechaModificacion;
    public $fechaV;

    //Método para obtener todos los usuarios que existen.
    public static function obtenerTodosLosUsuarios(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT u.id_Usuario, u.usuario, u.nombre_Usuario, u.correo_Electronico, e.descripcion, r.rol
                FROM tbl_ms_usuario AS u
                INNER JOIN tbl_estado_usuario AS e ON u.id_Estado_Usuario = e.id_Estado_Usuario 
                INNER JOIN tbl_ms_roles AS r ON u.id_Rol = r.id_Rol;";
        $listaUsuarios = sqlsrv_query($consulta, $query);
        $usuarios = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaUsuarios, SQLSRV_FETCH_ASSOC)) {
            $usuarios[] = [
                'IdUsuario' => $fila["id_Usuario"],
                'usuario' => $fila["usuario"],
                'nombreUsuario' => $fila["nombre_Usuario"],
                'correo' => $fila["correo_Electronico"],
                'Estado' => $fila["descripcion"],
                'Rol' => $fila["rol"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $usuarios;
    }
    //Método para crear nuevo usuario desde Autoregistro y gestion Usuario.
    public static function registroNuevoUsuario($nuevoUsuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $usuario =$nuevoUsuario->usuario;
        $nombre = $nuevoUsuario->nombre;
        $idEstado = $nuevoUsuario->idEstado;
        $idRol = $nuevoUsuario->idRol;
        $intentosRespuestas = $nuevoUsuario->intentosRespuestas;
        $contrasenia = $nuevoUsuario->contrasenia;
        $correo = $nuevoUsuario->correo;
        $cantIntentos = $nuevoUsuario->intentosFallidos;
        $creadoPor = $nuevoUsuario->creadoPor;
        $modificadoPor = $nuevoUsuario->modificadoPor;
        $cantPreguntasContestadas = $nuevoUsuario->preguntasContestadas;
        $fechaV = $nuevoUsuario->fechaV;
        $query = "INSERT INTO tbl_MS_Usuario (usuario, nombre_Usuario, id_Estado_Usuario, contrasenia, correo_Electronico, intentos_fallidos, id_Rol, 
        preguntas_Contestadas, int_respuestasFallidas, fecha_Vencimiento, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) 
        VALUES ('$usuario','$nombre', '$idEstado', '$contrasenia', '$correo', '$cantIntentos', '$idRol', 
        '$cantPreguntasContestadas', '$intentosRespuestas', '$fechaV', '$creadoPor', GETDATE(), '$modificadoPor', GETDATE());";
        $nuevoUsuario = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $nuevoUsuario;
    }
    public static function existeUsuario($userName, $userPassword){
        $passwordValida = false;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT contrasenia FROM tbl_MS_Usuario WHERE usuario = '$userName'";
        $usuario = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset
        // $existe = sqlsrv_num_rows($usuario);
        $existe = sqlsrv_has_rows($usuario);
        if ($existe) {
            $user = sqlsrv_fetch_array($usuario, SQLSRV_FETCH_ASSOC);
            $Password = $user['contrasenia'];
            $passwordValida = password_verify($userPassword, $Password);
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $passwordValida; //Si se encuentra un usuario válido/existente retorna un entero mayor a 0.
    }

    //Obtener intentos permitidos de la tabla parámetro
    public static function intentosPermitidos(){
        $intentos = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'ADMIN INTENTOS'";
        $intentos = sqlsrv_query($conexion, $query);
        //Obtenemos el valor de Intentos que viene de la DB
        $fila = sqlsrv_fetch_array($intentos, SQLSRV_FETCH_ASSOC);
        if(isset($fila["valor"])){
            $intentos = intval($fila["valor"]);
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $intentos;
    }
    //Obtener número de intentos falllidos del usuario en el login.
    public static function intentosInvalidos($usuario){
        $intentosFallidos = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $result = sqlsrv_query($conexion, $query); #Ejecutamos la consulta (Recordset)
        $existeUsuario = sqlsrv_has_rows($result);
        if($existeUsuario){
            $qr = "SELECT intentos_fallidos FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
            $intentosFallidos = sqlsrv_query($conexion, $qr);
            //Obtenemos el valor de Intentos que viene de la DB
            $fila = sqlsrv_fetch_array($intentosFallidos, SQLSRV_FETCH_ASSOC);
            if(isset($fila["intentos_fallidos"])){
                $intentosFallidos = intval($fila["intentos_fallidos"]); 
            } 
        } 
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $intentosFallidos;
    }
    public static function bloquearUsuario($intentosMax, $intentosFallidos, $user){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $estadoUser = false;
        if($intentosFallidos > $intentosMax){
            $nuevoEstado = 4;
            $query = "UPDATE tbl_MS_Usuario SET id_Estado_Usuario = '$nuevoEstado' WHERE usuario = '$user'";
            $estadoUser = sqlsrv_query($conexion, $query);
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoUser;
    }
    public static function aumentarIntentosFallidos($usuario, $intentosFallidos){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $incremento = 0;
        if($intentosFallidos<=3){
            $incremento = ($intentosFallidos + 1);
            $query = "UPDATE tbl_MS_Usuario SET intentos_fallidos = '$incremento' WHERE usuario = '$usuario';";
            sqlsrv_query($conexion, $query);
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $incremento;
    }
    //Obtener cantidad de preguntas desde el parámetro.
    public static function parametroPreguntas(){
        $cantPreguntas=0;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT valor FROM tbl_MS_Parametro WHERE Parametro = 'ADMIN PREGUNTAS'";
        $paramPreguntas = sqlsrv_query($consulta, $query);
        $row = sqlsrv_fetch_array($paramPreguntas, SQLSRV_FETCH_ASSOC);
        if(isset($row["valor"])){
            $cantPreguntas = $row["valor"];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $cantPreguntas;
    }
    public static function resetearIntentosFallidos($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $resetear = 0;
        $query = "UPDATE tbl_MS_Usuario SET intentos_fallidos = '$resetear' WHERE usuario = '$usuario'";
        $resetear = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
    public static function obtenerEstadoUsuario($usuario){
        $estado = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Estado_Usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $consultaEstado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consultaEstado, SQLSRV_FETCH_ASSOC);
        if(isset($fila["id_Estado_Usuario"])){
            $estado = $fila["id_Estado_Usuario"];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estado;
    }
    public static function obtenerDescripcionEstadoUsuario($idEstado){
        $estado = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT descripcion FROM tbl_Estado_Usuario WHERE id_Estado_Usuario = '$idEstado'";
        $consultaEstado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consultaEstado, SQLSRV_FETCH_ASSOC);
        if(isset($fila["descripcion"])){
            $estado = $fila["descripcion"];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estado;
    }
    public static function guardarPreguntas($usuario, $preguntas){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        foreach($preguntas as $pregunta){
            $query = "INSERT INTO tbl_ms_preguntas (pregunta, Creado_Por) VALUES ('$pregunta','$usuario');";
            $insertarPreguntas = sqlsrv_query($conexion, $query);
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
    }

    public static function obtenerPreguntasUsuario(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_pregunta, pregunta FROM tbl_ms_preguntas WHERE estado = 'activa';";
        $preguntasUsuario = sqlsrv_query($conexion, $query);
        $preguntas = array();
        while($fila = sqlsrv_fetch_array($preguntasUsuario, SQLSRV_FETCH_ASSOC)){
            $preguntas [] = [
                'id_pregunta' => $fila["id_pregunta"],
                'pregunta' => $fila["pregunta"]
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $preguntas;
    }
    public static function validarPreguntasUsuario($idPregunta, $usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "  SELECT pu.id_pregunta FROM tbl_MS_Preguntas_X_Usuario pu
        INNER JOIN tbl_MS_Usuario u ON u.id_Usuario = pu.id_Usuario
        WHERE u.usuario = '$usuario' AND pu.id_Pregunta = '$idPregunta';";
        $resultado = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($resultado);
        sqlsrv_close($conexion);
        return $existe;
    }
    public static function guardarRespuestasUsuario($usuario, $idPregunta, $respuesta){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_usuario FROM tbl_ms_usuario WHERE usuario = '$usuario'";
        $params = array($usuario);
        $consultaIdUsuario = sqlsrv_query($conexion, $query, $params);
        if ($consultaIdUsuario) {
            $fila = sqlsrv_fetch_array($consultaIdUsuario, SQLSRV_FETCH_ASSOC);
            $idUsuario = $fila["id_usuario"];
        // Inserta la respuesta utilizando una declaración preparada.
        $creadoPor = $usuario;
        date_default_timezone_set('America/Tegucigalpa');
        $fechaCreacion = date("Y-m-d");
        $qry = "INSERT INTO tbl_MS_Preguntas_X_Usuario (id_pregunta, id_usuario, respuesta, Creado_Por, Fecha_Creacion)
                VALUES ('$idPregunta', '$idUsuario', '$respuesta','$creadoPor', '$fechaCreacion');";
        $params = array($idPregunta, $idUsuario, $respuesta);
        $insert = sqlsrv_query($conexion, $qry, $params);

        if ($insert) {
            sqlsrv_close($conexion);
            return true; // Devuelve verdadera en la inserción exitosa
        } else {
            // Maneja el error de inserción aquí
            return false;
        }
    } else {
        // Maneja el error de inserción aquí
        return false;
    }
}
    //===================== METODO REPETIDO, REVISAR==========================
    public static function obEstadoUsuario(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Estado_Usuario, descripcion FROM tbl_estado_usuario;";
        $obtenerEstado = sqlsrv_query($conexion, $query);
        $estados = array();
        while($fila = sqlsrv_fetch_array($obtenerEstado, SQLSRV_FETCH_ASSOC)){
            $estados [] = [
                'id_Estado_Usuario' => $fila["id_Estado_Usuario"],
                'descripcion' => $fila["descripcion"]
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estados;

    }
    // ========================================================================
    public static function eliminarUsuario($usuario){
        try{
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_MS_Usuario WHERE usuario = '$usuario';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
        }catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }
    public static function editarUsuario($nuevoUsuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idUsuario = $nuevoUsuario->idUsuario;
        $usuario =$nuevoUsuario->usuario;
        $nombre = $nuevoUsuario->nombre;
        $correo =$nuevoUsuario->correo;
        $idEstado = $nuevoUsuario->idEstado;
        $idRol = $nuevoUsuario->idRol;
        $modificadoPor = $nuevoUsuario->modificadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $fechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_ms_usuario SET usuario='$usuario', nombre_usuario='$nombre', correo_Electronico='$correo', id_Estado_Usuario='$idEstado', id_Rol='$idRol', Modificado_Por='$modificadoPor', Fecha_Modificacion='$fechaModificacion' WHERE id_Usuario='$idUsuario' ";
        $nuevoUsuario = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
    public static function obtenerRolUsuario($usuario){
        $rolUsuario = null;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Rol FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $consultaRol = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consultaRol, SQLSRV_FETCH_ASSOC);
        if(isset($fila["id_Rol"])){
            $rolUsuario = $fila["id_Rol"];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return intval($rolUsuario);
    }
    public static function obtenerPreguntas($usuario){//método para obtener preguntas
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); 
        $query = "SELECT p.id_Pregunta, p.pregunta
            FROM  tbl_ms_preguntas_x_usuario AS pu
            INNER JOIN tbl_ms_preguntas AS p ON p.id_Pregunta = pu.id_Pregunta
            INNER JOIN tbl_ms_usuario AS u ON pu.id_Usuario = u.id_Usuario WHERE u.usuario = '$usuario'";
        $listaPreguntas = sqlsrv_query($consulta, $query);
        $preguntas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaPreguntas, SQLSRV_FETCH_ASSOC)){
            $preguntas [] = [
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }
    public static function validarUsuario($userName){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$userName'";
        $usuario = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset)
        $existe = sqlsrv_num_rows($usuario);
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $existe; //Si se encuentra un usuario válido/existente retorna un entero mayor a 0.
    }
    public static function intentosFallidosRespuesta(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $cantRespuestasFallidas = 0;
        $query ="SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'INTEN RESPUESTAS';";
        $ejecutar = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC);
        if(isset($fila["valor"])){
            $cantRespuestasFallidas = intval($fila["valor"]);
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $cantRespuestasFallidas;
    }
    public static function obtenerIntentosRespuestas($usuario){
        $cantRespuestas = '';
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT int_respuestasFallidas FROM tbl_MS_Usuario WHERE usuario = '$usuario';";
        $userCantRespuestas = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($userCantRespuestas, SQLSRV_FETCH_ASSOC);
        if(isset($fila["int_respuestasFallidas"])){
            $cantRespuestas = intval($fila["int_respuestasFallidas"]);
        }
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $cantRespuestas;
    }
    public static function reiniciarIntentosRespuesta($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query ="UPDATE tbl_MS_Usuario SET int_respuestasFallidas = 0 WHERE usuario = '$usuario';";
        $ejecutar = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
    public static function desbloquearUsuario($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_MS_Usuario SET id_Estado_Usuario = 2 WHERE usuario = '$usuario';";
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion);
    }
    public static function setearEstadoNuevoUsuario($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_MS_Usuario SET id_Estado_Usuario = 1 WHERE usuario = '$usuario';";
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion);
    }
    public static function aumentarIntentosFallidosRespuesta($usuario, $intentosFallidos){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $incremento = 0;
        $incremento = ($intentosFallidos + 1);
        $query = "UPDATE tbl_MS_Usuario SET int_respuestasFallidas = '$incremento' WHERE usuario = '$usuario';";
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $incremento;
    }
    // public static function 
    public static function obtenerRespuestaPregunta($idPregunta, $usuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $respuesta = 0;
        $query = "SELECT pu.respuesta FROM tbl_ms_preguntas_x_usuario pu
        INNER JOIN tbl_MS_Usuario us ON pu.id_Usuario = us.id_Usuario
        WHERE pu.id_Pregunta = '$idPregunta' AND us.usuario = '$usuario';";
        $ejecutar = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC);
        if(isset($fila['respuesta'])){
            $respuesta = $fila['respuesta'];
        }
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $respuesta; 
    }

    public static function bloquearUsuarioMetodoPregunta($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_MS_Usuario SET id_Estado_Usuario = 4 WHERE usuario = '$usuario'";
        $ejecutar = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion);
    }
    public static function correoUsuario($usuario){
        $correo = '';
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT correo_Electronico FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $resultEmail = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset)
        $existe = sqlsrv_has_rows($resultEmail);
        if($existe){
            $fila = sqlsrv_fetch_array($resultEmail, SQLSRV_FETCH_ASSOC);
            $correo = $fila['correo_Electronico'];
        }
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $correo;
    }
    public static function guardarToken($user, $creadoPor){
        $tokenListo = 0;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        //Obtenemos el ID de usuario que inicio el proceso de recuperación contraseña
        $querySelectU = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$user'";
        $usuario = sqlsrv_query($consulta, $querySelectU); #Ejecutamos la consulta (Recordset)
        $fila = sqlsrv_fetch_array($usuario, SQLSRV_FETCH_ASSOC);
        $idUsuario = $fila['id_Usuario']; //Capturamos el ID
        //Obtenemos el valor del parametro HORAS VIGENCIA TOKEN con el que asignamos el tiempo de expiración
        $queryVigenciaToken = "SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'HORAS VIGENCIA TOKEN';";
        $vigenciaToken = sqlsrv_query($consulta, $queryVigenciaToken);
        $filaToken = sqlsrv_fetch_array($vigenciaToken, SQLSRV_FETCH_ASSOC);
        $horasVencimiento = "";
        if (isset($filaToken['valor'])) {
            $horasVencimiento = intval($filaToken['valor']);
        } 
        $tokenUsuario = "SELECT token FROM tbl_Token WHERE id_usuario = '$idUsuario';";
        $ejecutar = sqlsrv_query($consulta, $tokenUsuario);
        if(sqlsrv_has_rows($ejecutar)){
            while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                $token = random_int(1000, 9999);
                if($token != intval($fila['token'])){
                    $queryInsert = "INSERT INTO tbl_token (id_usuario, Token, fecha_expiracion, Creado_Por, Fecha_Creacion)
                    VALUES ('$idUsuario','$token', DATEADD(HOUR, $horasVencimiento, GETDATE()), '$creadoPor', GETDATE())";
                    $resultado = sqlsrv_query($consulta, $queryInsert);
                    if($resultado){
                        $tokenListo = $token;
                    }
                break;
                }
            } 
        } else {
            $token = random_int(1000, 9999);
            $queryInsert = "INSERT INTO tbl_token (id_usuario, Token, fecha_expiracion, Creado_Por, Fecha_Creacion)
            VALUES ('$idUsuario','$token', DATEADD(HOUR, $horasVencimiento, GETDATE()), '$creadoPor', GETDATE())";
            $resultado = sqlsrv_query($consulta, $queryInsert);
            if($resultado){
                $tokenListo = $token;
            }
        }      
        sqlsrv_close($consulta); #Cerrar la conexión.        
        return $tokenListo;
    }
    //Nos dice si existe o no un usuario
    public static function usuarioExistente($usuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $user = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset)
        $existe = sqlsrv_has_rows($user);
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $existe;
    } 
    public static function obtenerCantPreguntasContestadas($usuario){
        $cantPreguntas = '';
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT preguntas_Contestadas FROM tbl_MS_Usuario WHERE usuario = '$usuario';";
        $params = array($usuario);
        $userCantPreguntas = sqlsrv_query($consulta, $query, $params);
        $fila = sqlsrv_fetch_array($userCantPreguntas, SQLSRV_FETCH_ASSOC);
        if(isset($fila["preguntas_Contestadas"])){
            $cantPreguntas = $fila["preguntas_Contestadas"];
        }
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $cantPreguntas;
    }
    
    public static function incrementarPreguntasContestadas($usuario, $valorActual){
        $incremento = $valorActual+1;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "UPDATE tbl_MS_Usuario  SET preguntas_Contestadas = '$incremento' WHERE usuario = '$usuario';";
        sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.
    }
    public static function cambiarEstadoNuevo($usuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "UPDATE tbl_MS_Usuario  SET id_Estado_Usuario= 2 WHERE usuario = '$usuario';";
        sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.
    }

    public static function inactivarUsuario($usuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "UPDATE tbl_MS_Usuario  SET id_Estado_Usuario= 3 WHERE usuario = '$usuario';";
        sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.
    }
    //Obtener contraseña actual y guardar en tbl_MS_historial_Contraseña
    public static function respaldarContraseniaActual($userCreador, $usuario, $contraseniaActual, $origenLlamadaFuncion){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query1 = "";
        switch ($origenLlamadaFuncion){
            case 1: {
                //Cuando se llame desde autoregistro
                $query1 = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
                $creadoPor = $usuario;
                break;
            }
            case 2: {
                //Cuando se llame desde gestion usuario
                $query1 = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
                $creadoPor = $userCreador;
                break;
            }
            case 3: {
                //Cuando se llame desde recuperacion contraseña
                $query1 = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$userCreador'";
                $creadoPor = $userCreador;
                break;
            }
        }
        $result = sqlsrv_query($consulta, $query1); #Ejecutamos la consulta (Recordset)
        $existe = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $idUser = $existe['id_Usuario'];
        //Guardamos contraseña
        
        $query2 = "INSERT INTO tbl_ms_hist_contrasenia (id_Usuario, contrasenia, Creado_Por, Fecha_Creacion) 
                VALUES ('$idUser','$contraseniaActual', '$creadoPor', GETDATE());";
        sqlsrv_query($consulta, $query2);
        sqlsrv_close($consulta); #Cerrar la conexión.        
    }

    public static function eliminarContrasena($Usuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT id_Hist, h.id_Usuario, u.usuario, h.contrasenia, h.Fecha_Creacion 
                FROM tbl_MS_Hist_Contrasenia as h
                inner join	tbl_MS_Usuario as u on u.id_Usuario = h.id_Usuario
                WHERE u.usuario = '$Usuario' ORDER BY id_Hist DESC;";
        $resultado = sqlsrv_query($consulta, $query);
        $HistorialC = array();
        while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
            $HistorialC [] = [
                'id' => $fila['id_Hist'],
                'id_Usuario' => $fila['id_Usuario'],
                'usuario'=>$fila['usuario'],
                'contrasenia' => $fila['contrasenia'],
                'Fecha_Creacion' => $fila['Fecha_Creacion']
            ];
        }
        $tamano = count($HistorialC);  
        
        if ($tamano > 10){
            $idH = $HistorialC[10]['id'];           
            $query2 = "DELETE FROM tbl_MS_Hist_Contrasenia WHERE id_Hist = $idH;";
            sqlsrv_query($consulta, $query2);
        }            
        sqlsrv_close($consulta); #Cerrar la conexión.
    } 

    public static function actualizaRContrasenia($usuario, $contrasenia){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "UPDATE tbl_MS_Usuario  SET contrasenia = '$contrasenia', Modificado_Por = '$usuario', 
                Fecha_Modificacion = GETDATE() WHERE usuario = '$usuario';";
        $actualizar = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $actualizar;
    }
    //Esto para saber desde donde fue creado el usuario. Si es desde Gestion Usuario se le pedira cambiar contraseña
    public static function origenNuevoUsuario($usuario){
        $creado = null;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT Creado_Por FROM tbl_MS_Usuario WHERE usuario = '$usuario';";
        $obtCreadoPor = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($obtCreadoPor, SQLSRV_FETCH_ASSOC);
        $user = $fila['Creado_Por'];
        if($usuario == $user){
           $creado = true;
        }else {
            $creado = false;
        }
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $creado;
    }
    public static function validarToken($usuario, $tokenUsuario){
        $vencido = 0; //Por defecto asumimos que el token no existe.
        $idUser = '';
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $user = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($user, SQLSRV_FETCH_ASSOC);
        if(isset($fila['id_Usuario'])){
            $idUser = $fila['id_Usuario'];
            $query2 = "SELECT DATEDIFF(HOUR, GETDATE(), fecha_expiracion) AS vencimiento FROM tbl_token WHERE id_usuario = '$idUser' AND token = '$tokenUsuario'";
            $resultado = sqlsrv_query($consulta, $query2);
            $vencToken = sqlsrv_has_rows($resultado);
            if($vencToken){ //Si el token existe entonces validamos su fecha de vencimiento
                $row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
                $FechaVenc = intval($row['vencimiento']);
                if($FechaVenc < 1){
                    $vencido = 1; //Si ya vencio devolvemos 1
                } else {
                    $vencido = 2; //Si no ha vencido devolvemos 2
                }   
            }
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $vencido;
    }
    //Recibe un usuario y devuelve un id de usuario.
    public static function obtenerIdUsuario($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT id_Usuario FROM tbl_ms_usuario WHERE usuario = '$usuario'";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $id = $fila['id_Usuario'];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $id;
    }

    public static function permisoConsultaRol($idRolUser, $id_Objeto){
        $permitido = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Objeto, permiso_Consultar FROM tbl_MS_Permisos WHERE id_Rol = '$idRolUser' and id_Objeto = '$id_Objeto';";
        $resultado = sqlsrv_query($conexion, $query);
       $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
       if(isset($fila['permiso_Consultar']) && $fila['permiso_Consultar'] == 'S'){
            $permitido = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $permitido ;
    }
    //Metodo que valida los objetos y los permisos del usuario sobre ellos
    public static function validarPermisoSobreObjeto($IdObjetoActual, $permisoConsulta) {
        $permitido = false;
            if(($permisoConsulta['idObjeto'] == $IdObjetoActual) && ($permisoConsulta['consulta'] == 'Y')){
                $permitido = true;
            }

        return $permitido;
    }

    public static function usuarioExiste($usuario){
        $existeUsuario = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $user = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($user);
        if($existe){
            $existeUsuario = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existeUsuario;
    }

    public static function CantVendedores(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "Select COUNT(id_Rol) as Cant from tbl_MS_Usuario where id_Rol = 3";
        $result = sqlsrv_query($conexion, $query);
        $resultArray = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $CantVendedores = $resultArray['Cant'];        
        sqlsrv_close($conexion);
        return $CantVendedores;
    }

    public static function obtenerVendedores()
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT  id_usuario, nombre_Usuario FROM tbl_MS_Usuario where id_Rol = 3";
        $listaVendedores = sqlsrv_query($conexion, $query);
        $vendedores = array();
        while ($fila = sqlsrv_fetch_array($listaVendedores, SQLSRV_FETCH_ASSOC)) {
            $vendedores[] = [
                'idUsuario_Vendedor' => $fila['id_usuario'],
                'nombreVendedor' => $fila['nombre_Usuario']
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $vendedores;
    }
    // Esta funcion trae los datos para el modal Editar
    public static function obtenerUsuariosPorId($IdUsuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT  nombre_Usuario, usuario, correo_Electronico, id_Rol, id_Estado_Usuario,Fecha_Creacion, fecha_Vencimiento 
        FROM tbl_ms_usuario WHERE id_Usuario = '$IdUsuario'";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        // $fecha_C = $fila['Fecha_Creacion'];

        $datosusuario = [
            'Nombre_Usuario' => $fila['nombre_Usuario'],
            'Usuario' => $fila['usuario'],
            'Correo_Electronico' => $fila['correo_Electronico'],
            'Id_Rol' => $fila['id_Rol'],
            'Id_Estado_Usuario' => $fila['id_Estado_Usuario'],
            'Fecha_Creacion' => $fila['Fecha_Creacion'],
            'Fecha_Vencimiento' => $fila['fecha_Vencimiento']    
        ];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $datosusuario;
    }

    public static function obtenerIdUsuariosPassword() {
        $usuarios = array();
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Usuario, contrasenia from tbl_MS_Usuario where id_Estado_Usuario = 2";
        $resultado = sqlsrv_query($conexion, $query);
        //recorrer todos los usuarios y almacenarlos en un array
        while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $usuarios[] = [
                'idUsuario' => $fila['id_Usuario'],
                'contrasenia' => $fila['contrasenia']
            ];            
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $usuarios;
    }

    public static function actualizarFechaVencimientoContrasena($ArrayUsuarios, $vigenciaPassword) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        try {
            foreach ($ArrayUsuarios as $usuario){
                $idUsuario = $usuario['idUsuario'];
                $query = "SELECT id_Hist, contrasenia from tbl_MS_Hist_Contrasenia where id_Usuario = '$idUsuario'";           
                $listaUsuario = sqlsrv_query($conexion, $query);
                while ($fila = sqlsrv_fetch_array($listaUsuario, SQLSRV_FETCH_ASSOC)) {                   
                    if($fila['contrasenia'] == $usuario['contrasenia']){
                        $idHist = $fila['id_Hist'];
                        $query2 = "UPDATE tbl_MS_Usuario
                        SET fecha_Vencimiento = DATEADD(DAY, $vigenciaPassword, (SELECT Fecha_Creacion 
                        FROM tbl_MS_Hist_Contrasenia WHERE id_Hist = '$idHist' and id_Usuario = '$idUsuario')) 
                        where id_Usuario = '$idUsuario';";
                        sqlsrv_query($conexion, $query2);                       
                    }            
                }
            }
        }catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion);
    }
    public static function parametrosContrasenia() {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        // Obtener la longitud mínima de la contraseña
        $queryMin = "SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'MIN PASS'";
        $resultadoMin = sqlsrv_query($consulta, $queryMin);
        $rowMin = sqlsrv_fetch_array($resultadoMin, SQLSRV_FETCH_ASSOC);
        if(isset($rowMin["valor"])){
            $resultadoMin = (int)$rowMin["valor"];
        }
        // Obtener la longitud máxima de la contraseña
        $queryMax = "SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'MAX PASS'";
        $resultadoMax = sqlsrv_query($consulta, $queryMax);
        $rowMax = sqlsrv_fetch_array($resultadoMax, SQLSRV_FETCH_ASSOC);
        if(isset($rowMax["valor"])){
            $resultadoMax = (int)$rowMax["valor"];
        }
        sqlsrv_close($consulta);

        return [$resultadoMin, $resultadoMax];


    }  public static function obtenerDatosPerfilUsuario($userName){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT u.nombre_Usuario, u.rtn, u.Correo_Electronico, u.telefono, u.direccion,r.id_Rol, r.rol
                FROM tbl_MS_Usuario AS u
                INNER JOIN tbl_MS_Roles AS r ON u.id_Rol = r.id_Rol
                WHERE u.usuario = '$userName';";
        $resultado=sqlsrv_query($conexion,$query);
        $arraydatos=sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $datosPerfil=[ 
            'nombre'=>$arraydatos['nombre_Usuario'],
            'rtn'=>$arraydatos['rtn'],
            'correo'=>$arraydatos['Correo_Electronico'],
            'telefono'=>$arraydatos['telefono'],
            'direccion'=>$arraydatos['direccion'],
            'idRol'=>$arraydatos['id_Rol'],
            'rol_name'=>$arraydatos['rol']

        ];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $datosPerfil;
    }

    public static function editarPerfilUsuario($nuevoUsuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $nombre = $nuevoUsuario->nombre;
        $rtn = $nuevoUsuario->rtn;
        $email =$nuevoUsuario->correo;
        $telefono = $nuevoUsuario->telefono;
        $direccion = $nuevoUsuario->direccion;
        $modificadoPor = $nuevoUsuario->modificadoPor;
        $query = "UPDATE tbl_ms_usuario
         SET nombre_Usuario='$nombre',rtn='$rtn',Correo_Electronico='$email', 
         telefono='$telefono', direccion='$direccion', Modificado_Por='$modificadoPor',Fecha_Modificacion = GETDATE()
         WHERE usuario='$nuevoUsuario->usuario';";
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
  
    public static function estadoFechaVencimientoContrasenia($user){
        $estado = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT DATEDIFF(DAY,  GETDATE(), fecha_Vencimiento) AS ESTADO 
                  from tbl_MS_Usuario where usuario = '$user'";
        $resultado = sqlsrv_query($conexion, $query);
        $estadoVenc = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        if (intval($estadoVenc['ESTADO'])>=1){
            $estado = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estado;
    }

    public static function estadoValidacionContrasenas ($user, $contrasenia){
        $cont = 0;
        $estadoContra = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Hist, H.id_Usuario, u.usuario, H.contrasenia 
        FROM tbl_MS_Hist_Contrasenia as H
        inner join tbl_MS_Usuario as u on u.id_Usuario = H.id_Usuario
        WHERE u.usuario = '$user';";
        $resultado = sqlsrv_query($conexion, $query);
        while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) { 
            $estadoContra = password_verify($contrasenia, $fila['contrasenia']);
            if ($estadoContra){
                break;
            }            
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoContra;
    }
    public static function depurarToken($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = " SELECT COUNT(tk.id_token) AS Cant FROM tbl_Token tk 
        INNER JOIN tbl_MS_Usuario us ON tk.id_usuario = us.id_Usuario
        WHERE us.usuario = '$usuario';";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        if(intval($fila['Cant']) == 10){
            $idToken = "SELECT tk.id_token FROM tbl_Token tk 
            INNER JOIN tbl_MS_Usuario us ON tk.id_usuario = us.id_Usuario
            WHERE tk.Fecha_Creacion = (SELECT MIN(tk.Fecha_Creacion) FROM tbl_Token tk) AND us.usuario = '$usuario';";
            $resultado = sqlsrv_query($conexion, $idToken);
            $filaIdToken = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            $id = $filaIdToken['id_token'];
            $query = "DELETE FROM tbl_Token WHERE id_token = '$id';";
            $resultado = sqlsrv_query($conexion, $query);
        }
        sqlsrv_close($conexion);
    }
    public static function correoExiste($correo){
        $existeCorreo = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT correo_Electronico  FROM tbl_MS_Usuario WHERE correo_Electronico = '$correo'";
        $user = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($user);
        if($existe){
            $existeCorreo = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existeCorreo;
    }
    public static function reiniciarIntentosFallidos($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_MS_Usuario SET intentos_fallidos = 0 WHERE usuario = '$usuario';";
        $ejecutar = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
     }


    //Método para generar el reporte de usuarios.
    public static function obtenerLosUsuariosPDF($buscar){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT u.id_Usuario, u.usuario, u.nombre_Usuario, u.correo_Electronico, e.descripcion, r.rol
        FROM tbl_ms_usuario AS u
        INNER JOIN tbl_estado_usuario AS e ON u.id_Estado_Usuario = e.id_Estado_Usuario 
        INNER JOIN tbl_ms_roles AS r ON u.id_Rol = r.id_Rol
        WHERE CONCAT(u.id_Usuario, u.usuario, u.nombre_Usuario, u.correo_Electronico, e.descripcion, r.rol) LIKE '%' + '$buscar' + '%';";
        $listaUsuarios = sqlsrv_query($consulta, $query);
        $usuarios = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaUsuarios, SQLSRV_FETCH_ASSOC)) {
            $usuarios[] = [
                'IdUsuario' => $fila["id_Usuario"],
                'usuario' => $fila["usuario"],
                'nombreUsuario' => $fila["nombre_Usuario"],
                'correo' => $fila["correo_Electronico"],
                'Estado' => $fila["descripcion"],
                'Rol' => $fila["rol"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $usuarios;
    }
    public static function obtenerRolUser($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT ro.rol FROM tbl_ms_usuario us INNER JOIN tbl_MS_Roles ro ON us.id_Rol = ro.id_Rol
        WHERE us.usuario = '$usuario';";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $rolUsuario = $fila['rol'];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $rolUsuario;
    }
}#Fin de la clase

    

