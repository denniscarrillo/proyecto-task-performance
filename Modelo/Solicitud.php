<?php

class Solicitud {
    public $idSolicitud;
    public $idEstadoSolicitud;
    public $idTipoServicio;
    public $idUsuario;
    public $fecha_Envio;
    public $idCliente;
    public $correo;
    public $descripcion;
    public $ubicacion;
    public $tituloMensaje;
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
    
}

    