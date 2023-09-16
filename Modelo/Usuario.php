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
    public $idCargo;
    public $creadoPor;
    public $fechaCreacion;
    public $reseteoClave;
    public $modificadoPor;
    public $fechaModificacion;

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
        $contrasenia = $nuevoUsuario->contrasenia;
        $correo = $nuevoUsuario->correo;
        $cantIntentos = $nuevoUsuario->intentosFallidos;
        $creadoPor = $nuevoUsuario->creadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $fechaCreacion = date("Y-m-d");
        $cantPreguntasContestadas = $nuevoUsuario->preguntasContestadas;
        $query = "INSERT INTO tbl_MS_Usuario (usuario, nombre_Usuario, id_Estado_Usuario, contrasenia, correo_Electronico, intentos_fallidos, 
                                        id_Rol, preguntas_Contestadas, Creado_Por, Fecha_Creacion) 
                        VALUES ('$usuario','$nombre', '$idEstado', '$contrasenia', '$correo', '$cantIntentos', '$idRol', '$cantPreguntasContestadas', '$creadoPor', '$fechaCreacion' )";
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
            $intentos = $fila["valor"];
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
                $intentosFallidos = $fila["intentos_fallidos"]; 
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
        $query = "SELECT id_pregunta, pregunta FROM tbl_ms_preguntas;";
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
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Usuario FROM tbl_ms_usuario WHERE usuario = '$usuario'";
        $consultaIdUsuario = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consultaIdUsuario, SQLSRV_FETCH_ASSOC);
        $idUsuario = $fila['id_Usuario'];
        //Eliminamos el usuario
        $qry = "DELETE FROM tbl_ms_usuario WHERE id_Usuario = $idUsuario;";
        $estadoEliminado = sqlsrv_query($conexion, $qry);
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
    public static function obtenerRespuestaPregunta($idPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT respuesta FROM tbl_ms_preguntas_x_usuario WHERE id_Pregunta = '$idPregunta';";
        $respuesta = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($respuesta, SQLSRV_FETCH_ASSOC);
        $respuesta = $fila['respuesta'];
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $respuesta; 
    }
    public static function correoUsuario($usuario){
        $correo = '';
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT correo_Electronico FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $usuario = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset)
        $existe = sqlsrv_has_rows($usuario);
        if($existe > 0){
            $fila = sqlsrv_fetch_array($usuario, SQLSRV_FETCH_ASSOC);
            $correo = $fila['correo_Electronico'];
        }
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $correo;
    }
    public static function guardarToken($user, $token){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$user'";
        $usuario = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset)
        $fila = sqlsrv_fetch_array($usuario, SQLSRV_FETCH_ASSOC);
        $idUsuario = $fila['id_Usuario'];
        $query = "INSERT INTO tbl_token (id_usuario, Token)
                    VALUES ('$idUsuario','$token')";
        $resultado = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.        
        return $resultado;
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
    //Obtener contraseña actual y guardar en tbl_MS_historial_Contraseña
    public static function respaldarContraseniaAnterior($usuario){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT id_Usuario, contrasenia FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $usuario = sqlsrv_query($consulta, $query); #Ejecutamos la consulta (Recordset)
        $existe = sqlsrv_fetch_array($usuario, SQLSRV_FETCH_ASSOC);
        $idUser = $existe['id_Usuario'];
        $contraseniaActual = $existe['contrasenia'];
        //Guardamos contraseña
        $creadoPor = $usuario;
        date_default_timezone_set('America/Tegucigalpa');
        $fechaCreacion = date("Y-m-d");
       $query = "INSERT INTO tbl_ms_hist_contrasenia (id_Usuario, contrasenia, Creado_Por, Fecha_Creacion) VALUES ('$idUser','$contraseniaActual', '$creadoPor', '$fechaCreacion');";
       $guardar = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $guardar; //Si se guardo retorna true.
    }
    public static function actualizaRContrasenia($usuario, $contrasenia){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "UPDATE tbl_MS_Usuario  SET contrasenia = '$contrasenia' WHERE usuario = '$usuario';";
        $actualizar = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerrar la conexión.
        return $actualizar;
    }
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
        $existe = false;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Conexión a la DB.
        $query = "SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$usuario'";
        $user = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($user, SQLSRV_FETCH_ASSOC);
        $idUser = $fila['id_Usuario'];
        $query2 = "SELECT token FROM tbl_token WHERE id_usuario='$idUser'";
        $validar = sqlsrv_query($consulta, $query2);
        while($row = sqlsrv_fetch_array($validar, SQLSRV_FETCH_ASSOC)){
            if($tokenUsuario == $row['token']){
                $existe = true;
                break;
            }
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $existe;
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
    public static function permisosRol($idRolUser){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Objeto, permiso_Consultar, permiso_Insercion, permiso_Actualizacion, permiso_Eliminacion  
        FROM tbl_MS_Permisos WHERE id_Rol = '$idRolUser';";
        $resultado = sqlsrv_query($conexion, $query);
        while($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
            $permisoRol [] = [
                'idObjeto' => $fila['id_Objeto'],
                'consulta' => $fila['permiso_Consultar'],
                'insertar' => $fila['permiso_Insercion'],
                'actualizar' => $fila['permiso_Actualizacion'],
                'eliminar' => $fila['permiso_Eliminacion']
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $permisoRol;
    }
    //Metodo que valida los objetos y los permisos del usuario sobre ellos
    public static function validarPermisoSobreObjeto($userName, $IdObjetoActual, $permisosRol) {
        $permitido = false;
        foreach ($permisosRol as $objeto) {
            if($objeto['idObjeto'] == $IdObjetoActual && $objeto['consulta'] == 'Y'){
                $permitido = true;
                break;
            }
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

    public static function obtenerVendedores($idTarea)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT vt.id_usuario_vendedor, u.Usuario FROM tbl_vendedores_tarea AS vt
        INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = vt.id_usuario_vendedor WHERE vt.id_Tarea = $idTarea;";
        $listaVendedores = sqlsrv_query($conexion, $query);
        $vendedores = array();
        while ($fila = sqlsrv_fetch_array($listaVendedores, SQLSRV_FETCH_ASSOC)) {
            $vendedores[] = [
                'idVendedor' => $fila['id_usuario_vendedor'],
                'nombreVendedor' => $fila['Usuario']
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $vendedores;
    }



}#Fin de la clase