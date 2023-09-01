<?php

class Solicitud {
    public $idSolicitud;
    public $idEstadoSolicitud;
    public $idTipoServicio;
    public $idUsuario;
    public $fechaEnvio;
    public $idCliente;
    public $correo;
    public $descripcion;
    public $ubicacion;
    public $titulo;
    public $creado_Por;
    public $fecha_Creacion;
    public $modificado_Por;
    public $fecha_Modificacion;

    //Método para obtener todos los solicitudes que existen.
    public static function obtenerTodasLasSolicitudes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaSolicitudes = 
            $query = "SELECT s.id_Solicitud, s.fecha_Envio, s.descripcion,
            s.correo, s.ubicacion, e.estadoSolicitud, t.servicio_Tecnico, c.NOMBRECLIENTE, u.usuario
            FROM tbl_solicitud AS s
            INNER JOIN tbl_estadosolicitud AS e ON s.id_EstadoSolicitud = e.id_EstadoSolicitud
            INNER JOIN tbl_tiposervicio AS t ON s.id_tipoServicio = t.id_tipoServicio
            INNER JOIN View_Clientes AS c ON s.CODCLIENTE = c.CODCLIENTE
            INNER JOIN tbl_ms_usuario AS u ON s.id_Usuario = u.id_Usuario;
            ";
        $listaSolicitudes = sqlsrv_query($consulta, $query);
        $solicitudes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaSolicitudes, SQLSRV_FETCH_ASSOC)){
            $solicitudes [] = [
                'IdSolicitud' => $fila["id_Solicitud"],
                'Fecha_Envio' => $fila["fecha_Envio"],
                'Descripcion'=> $fila["descripcion"],
                'Correo' => $fila["correo"],
                'Ubicacion' => $fila["ubicacion"],
                'EstadoSolicitud' => $fila["estadoSolicitud"],
                'ServicioTecnico' => $fila["servicio_Tecnico"],
                'NombreCliente' => $fila["NOMBRECLIENTE"],
                'Usuario' => $fila["usuario"],
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $solicitudes;
    }
    

    public static function crearNuevaSolicitud($nuevaSolicitud){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $idUsuario = $nuevaSolicitud->idUsuario;
        $idEstadoSolicitud = $nuevaSolicitud->idEstadoSolicitud;
        $idTipoServicio = $nuevaSolicitud->idTipoServicio;
        $idCliente = $nuevaSolicitud->idCliente;
        $fechaEnvio = $nuevaSolicitud->fechaEnvio;
        $titulo = $nuevaSolicitud->titulo;
        $correo = $nuevaSolicitud->correo;
        $descripcion = $nuevaSolicitud->descripcion;
        $ubicacion = $nuevaSolicitud->ubicacion;
        $query = "INSERT INTO tbl_solicitud (id_Usuario, id_EstadoSolicitud, id_TipoServicio, id_Cliente, fecha_Envio, titulo_Mensaje, correo, descripcion, ubicacion) 
        VALUES ('$idUsuario', '$idEstadoSolicitud', '$idTipoServicio', '$idCliente', '$fechaEnvio', '$titulo', '$correo', '$descripcion', '$ubicacion' )";
        $nuevaSolicitud = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        /*return $nuevaSolicitud;*/
    }

    public static function obtenerEstadoSolicitud(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_EstadoSolicitud, estadoSolicitud FROM tbl_estadoSolicitud;";
        $obtenerEstado = sqlsrv_query($conexion, $query);
        $estados = array();
        while($fila = sqlsrv_fetch_array($obtenerEstado, SQLSRV_FETCH_ASSOC)){
            $estados [] = [
                'id_EstadoSolicitud' => $fila["id_EstadoSolicitud"],
                'estadoSolicitud' => $fila["estadoSolicitud"]
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estados;
    }

    public static function obtenerTipoServicio(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_TipoServicio, servicio_Tecnico FROM tbl_tipoServicio;";
        $obtenerTipoServicio = sqlsrv_query($conexion, $query);
        $servicios = array();
        while($fila = $obtenerTipoServicio->fetch_assoc()){
            $servicios [] = [
                'id_TipoServicio' => $fila["id_TipoServicio"],
                'servicio_Tecnico' => $fila["servicio_Tecnico"]
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $servicios;
    }

    public static function editarSolicitud($editarSolicitud){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idSolicitud = $editarSolicitud->idSolicitud;
        $usuario = $editarSolicitud->usuario;
        $idEstadoSolicitud = $editarSolicitud->idEstadoSolicitud;
        $idTipoServicio = $editarSolicitud->idTipoServicio;
        $cliente = $editarSolicitud->idCliente;
        /*$tituloMensaje = $editarSolicitud->titulo;*/
        $fechaEnvio = $editarSolicitud->fechaEnvio;
        $descripcion = $editarSolicitud->descripcion;
        $correo = $editarSolicitud->correo;
        $ubicacion = $editarSolicitud->ubicacion;
        $query = "UPDATE tbl_solicitud SET id_Usuario = '$usuario', id_EstadoSolicitud = '$idEstadoSolicitud', id_TipoServicio='$idTipoServicio', id_Cliente = '$cliente', fecha_Envio = '$fechaEnvio', correo ='$correo', descripcion = '$descripcion',  ubicacion = '$ubicacion' WHERE id_Solicitud='$idSolicitud' ";
        $editarSolicitud = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }

    public static function obtenerCliente(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Cliente, nombre_Cliente FROM tbl_vista_cliente;";
        $clientesSolicitud = sqlsrv_query($conexion, $query);
        $clientes = array();
        while($fila = sqlsrv_fetch_array($clientesSolicitud, SQLSRV_FETCH_ASSOC)){
            $clientes [] = [
                'id_Cliente' => $fila["id_Cliente"],
                'nombre_Cliente' => $fila["nombre_Cliente"]
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $clientes;
    }


    public static function eliminarSolicitud($solicitud){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Solicitud FROM tbl_solicitud WHERE descripcion = '$solicitud'";
        $consultaIdSolicitud = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consultaIdSolicitud, SQLSRV_FETCH_ASSOC);
        $idSolicitud = $fila['id_Solicitud'];
        //Eliminamos la solicitud
        $query2 = "DELETE FROM tbl_solicitud WHERE id_Solicitud = $idSolicitud;";
        $estadoEliminado = sqlsrv_query($conexion, $query2);
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }
}
