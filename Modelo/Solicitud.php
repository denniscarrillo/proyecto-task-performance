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
            $consulta->query("SELECT s.id_Solicitud, s.fecha_Envio, s.descripcion,
            s.correo, s.ubicacion, e.estadoSolicitud, t.servicio_Tecnico, c.nombre_Cliente, u.usuario
            FROM tbl_solicitud AS s
            INNER JOIN tbl_estadosolicitud AS e ON s.id_EstadoSolicitud = e.id_EstadoSolicitud
            INNER JOIN tbl_tiposervicio AS t ON s.id_tipoServicio = t.id_tipoServicio
            INNER JOIN tbl_vista_cliente AS c ON s.id_Cliente = c.id_Cliente
            INNER JOIN tbl_ms_usuario AS u ON s.id_Usuario = u.id_Usuario;
            ");
        $solicitudes = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaSolicitudes->fetch_assoc()){
            $solicitudes [] = [
                'IdSolicitud' => $fila["id_Solicitud"],
                'Fecha_Envio' => $fila["fecha_Envio"],
                'Descripcion'=> $fila["descripcion"],
                'Correo' => $fila["correo"],
                'Ubicacion' => $fila["ubicacion"],
                'EstadoSolicitud' => $fila["estadoSolicitud"],
                'ServicioTecnico' => $fila["servicio_Tecnico"],
                'NombreCliente' => $fila["nombre_Cliente"],
                'Usuario' => $fila["usuario"],
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
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
        $nuevaSolicitud = $consulta->query("INSERT INTO tbl_solicitud(id_Usuario, id_EstadoSolicitud, id_TipoServicio, id_Cliente, fecha_Envio, titulo_Mensaje, descripcion, correo, ubicacion) 
        VALUES ($idUsuario, $idEstadoSolicitud, $idTipoServicio, $idCliente, $fechaEnvio, $titulo,  $correo, $descripcion, $ubicacion)");
        mysqli_close($consulta); #Cerramos la conexión.
        return $nuevaSolicitud;
    }

    public static function obtenerEstadoSolicitud(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $obtenerEstado = $conexion->query("SELECT id_EstadoSolicitud, estadoSolicitud FROM tbl_estadoSolicitud;");
        $estados = array();
        while($fila = $obtenerEstado->fetch_assoc()){
            $estados [] = [
                'id_EstadoSolicitud' => $fila["id_EstadoSolicitud"],
                'estadoSolicitud' => $fila["estadoSolicitud"]
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $estados;
    }

    public static function obtenerTipoServicio(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $obtenerTipoServicio = $conexion->query("SELECT id_TipoServicio, servicio_Tecnico FROM tbl_tipoServicio;");
        $servicios = array();
        while($fila = $obtenerTipoServicio->fetch_assoc()){
            $servicios [] = [
                'id_TipoServicio' => $fila["id_TipoServicio"],
                'servicio_Tecnico' => $fila["servicio_Tecnico"]
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $servicios;
    }

    public static function editarSolicitud($modificarSolicitud){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $usuario = $modificarSolicitud->usuario;
        $idEstadoSolicitud = $modificarSolicitud->idEstadoSolicitud;
        $idTipoServicio = $modificarSolicitud->idTipoServicio;
        $cliente = $$modificarSolicitud->idCliente;
        $tituloMensaje = $$modificarSolicitud->titulo;
        $fechaEnvio = $$modificarSolicitud->fechaEnvio;
        $descripcion = $$modificarSolicitud->descripcion;
        $correo = $$modificarSolicitud->correo;
        $ubicacion = $$modificarSolicitud->ubicacion;
        $modificarSolicitud = $conexion->query("UPDATE tbl_solicitud SET id_Usuario = '$usuario', id_EstadoSolicitud= '$idEstadoSolicitud', id_TipoServicio=$idTipoServicio, id_Cliente = $cliente, fecha_Envio = $fechaEnvio, titulo_Mensaje = $tituloMensaje, correo ='$correo', descripcion = $descripcion,  ubicacion = $ubicacion WHERE id_Usuario='$idUsuario' ");
        mysqli_close($conexion); #Cerramos la conexión.
    }
}
