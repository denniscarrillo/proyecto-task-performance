<?php

class DataTableSolicitud
{
    public $idSolicitud;
    public $idTipoSolicitud;
    public $EstadoAvance;
    public $EstadoSolicitud;
    public $TelefonoCliente;
    public $FechaCreacion;
    public $MotivoCancelacion;

    // Obtener todas las solicitudes .
    public static function obtenerSolicitud()
    {
        $SolicitudesUsuario = null;
        try {
            $SolicitudesUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT id_Solicitud,
                        cc.nombre_Cliente AS NombreCliente,
                        t.servicio_Tecnico,
                        telefono_cliente,
                        EstadoAvance,
                        s.Fecha_Creacion
                    FROM [tbl_Solicitud] AS s
                    INNER JOIN tbl_TipoServicio AS t ON t.id_TipoServicio = s.id_TipoServicio
                    LEFT JOIN tbl_CarteraCliente AS cc ON cc.rtn_Cliente = s.rtn_clienteCartera 
                    WHERE s.cod_Cliente IS NULL OR s.cod_Cliente = 'NULL' OR s.cod_Cliente = '' 
                    ORDER BY id_Solicitud;";

           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $SolicitudesUsuario[] = [
                    'id_Solicitud' => $fila['id_Solicitud'],
                    'Nombre' => $fila['NombreCliente'],
                    'servicio_Tecnico' => $fila['servicio_Tecnico'],
                    'telefono' => $fila['telefono_cliente'],
                    'EstadoAvance' => $fila['EstadoAvance'],
                    'Fecha_Creacion' => $fila['Fecha_Creacion']
                   
                ];
            }
        } catch (Exception $e) {
            $SolicitudesUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $SolicitudesUsuario;
    } 


    public static function actualizarEstadoSolicitud($cancelarSolicitud){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $idSolicitud=$cancelarSolicitud->idSolicitud;
            $EstadoAvance = $cancelarSolicitud->EstadoAvance;
            $EstadoSolicitud=$cancelarSolicitud->EstadoSolicitud;
            $MotivoCancelacion=$cancelarSolicitud->MotivoCancelacion;
            $modificadoPor=$cancelarSolicitud->modificadoPor;
            $query ="UPDATE tbl_Solicitud SET EstadoAvance='$EstadoAvance', EstadoSolicitud='$EstadoSolicitud', motivo_cancelacion = '$MotivoCancelacion', 
            Modificado_Por='$modificadoPor', Fecha_Modificacion = GETDATE()
            WHERE id_Solicitud='$idSolicitud';";
            $cancelarSolicitud = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion

    }

    public static function editarSolicitud($EditarSolicitud){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $idSolicitud = $EditarSolicitud->idSolicitud;
        $descripcion = $EditarSolicitud->descripcion;
        $telefono = $EditarSolicitud->telefono;
        $ubicacion = $EditarSolicitud->ubicacion;
        $EstadoAvance = $EditarSolicitud->EstadoAvance;
        $ModificadoPor = $EditarSolicitud->ModificadoPor;
        $query = "UPDATE tbl_Solicitud SET descripcion = '$descripcion', telefono_cliente = '$telefono', 
		ubicacion_instalacion = '$ubicacion', EstadoAvance ='$EstadoAvance',
        Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE()
        WHERE id_Solicitud = '$idSolicitud';";
        $EditarSolicitud = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $EditarSolicitud;
    }

    public static function VerSolicitudesPorId ($idSolicitud){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT id_Solicitud
        ,idFactura,s.rtn_cliente,s.rtn_clienteCartera,
         cc.nombre_Cliente AS NombreCliente
        ,descripcion,t.servicio_Tecnico,s.correo,telefono_cliente,ubicacion_instalacion,EstadoAvance
        ,EstadoSolicitud,motivo_cancelacion,s.Creado_Por,s.Fecha_Creacion,s.Modificado_Por,s.Fecha_Modificacion
        FROM [tbl_Solicitud] as s
        inner join tbl_TipoServicio as t on t.id_TipoServicio = s.id_TipoServicio
        LEFT join tbl_CarteraCliente as cc on cc.rtn_Cliente = s.rtn_clienteCartera
        Where s.cod_Cliente IS NULL OR s.cod_Cliente = 'NULL' OR s.cod_Cliente = '' 
		AND id_Solicitud = $idSolicitud;";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $datosVerSolicitudes = [
            'idSolicitud' => $fila['id_Solicitud'],
            'idFactura' => $fila['idFactura'],
            'rtnClienteCartera' => $fila['rtn_clienteCartera'],
            'NombreCliente' => $fila['NombreCliente'],
            'Descripcion' => $fila['descripcion'],
            'TipoServicio' => $fila['servicio_Tecnico'],
            'Correo' => $fila['correo'],
            'telefono' => $fila['telefono_cliente'],
            'ubicacion' => $fila['ubicacion_instalacion'],
            'EstadoAvance' => $fila['EstadoAvance'],
            'EstadoSolicitud' => $fila['EstadoSolicitud'],
            'motivoCancelacion' => $fila['motivo_cancelacion'],
            'CreadoPor' => $fila['Creado_Por'],
            'FechaCreacion' => $fila['Fecha_Creacion'],  
            'ModificadoPor' => $fila['Modificado_Por'],
            'FechaModificacion' => $fila['Fecha_Modificacion']  
        ];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $datosVerSolicitudes;
    }


    public static function NuevaSolicitud($nuevaSolicitud, $productosSolicitud){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $idFactura =$nuevaSolicitud->idFactura;
        //$rtnCliente = $nuevaSolicitud->rtnCliente;
        $rtnClienteCartera = $nuevaSolicitud->rtnClienteC;
        $Descripcion = $nuevaSolicitud->descripcion;
        $TipoServicio = $nuevaSolicitud->tipoServicio;
        $Correo = $nuevaSolicitud->correo;
        $telefono = $nuevaSolicitud->telefono;
        $ubicacion = $nuevaSolicitud->ubicacion;
        $EstadoAvance = $nuevaSolicitud->estadoAvance;
        $EstadoSolicitud = $nuevaSolicitud->estadoSolicitud;
        $CreadoPor = $nuevaSolicitud->creadoPor;
        //$codigoC = $nuevaSolicitud->codigoCliente;
        
        $query = "INSERT INTO tbl_Solicitud(idFactura, rtn_clienteCartera, descripcion, 
        id_TipoServicio, correo, telefono_cliente, ubicacion_instalacion, EstadoAvance, EstadoSolicitud, 
        Creado_Por, Fecha_Creacion) 
        VALUES ('$idFactura', '$rtnClienteCartera', '$Descripcion', '$TipoServicio', '$Correo',
        '$telefono', '$ubicacion', '$EstadoAvance', '$EstadoSolicitud','$CreadoPor', GETDATE()) ;";
        $nuevaSolicitud = sqlsrv_query($consulta, $query);

        $query2 = "SELECT SCOPE_IDENTITY() AS id_Solicitud";
        $resultado = sqlsrv_query($consulta, $query2);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $idSolicitud= $fila['id_Solicitud'];
        foreach($productosSolicitud as $producto){
            $CodArticulo = $producto['idProducto'];
            $Cant = $producto['CantProducto'];
            $insertProductoS = "INSERT INTO tbl_ProductosSolicitud(id_Solicitud, Cod_Articulo, Cant) 
                                VALUES ( $idSolicitud, $CodArticulo, $Cant);";        
            sqlsrv_query($consulta, $insertProductoS);
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return array('nuevaSolicitud' => $nuevaSolicitud, 'idSolicitud' => $idSolicitud);
    }

    public static function NuevoProductoSolic($nuevoProductoS){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $idSolicitud =$nuevoProductoS->idSolicitud;
        $CodArticulo = $nuevoProductoS->CodArticulo;
        $Cant = $nuevoProductoS->Cant;        
        $query = "INSERT INTO tbl_ProductosSolicitud(id_Solicitud, Cod_Articulo, Cant) 
        VALUES ('$idSolicitud',' $CodArticulo', ' $Cant');";
        $nuevoProductoS = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $nuevoProductoS;
    }

    public static function obtenerArticuloS($idSolicitud){
        $verArticulos = null;
        try {
            $verArticulos = array();
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query="SELECT id_Solicitud, Cod_Articulo, ARTICULO, Cant
            FROM tbl_ProductosSolicitud as p
            INNER JOIN tbl_ARTICULOS as a on a.CODARTICULO = p.Cod_Articulo
            Where id_Solicitud = $idSolicitud;";
            $resultado = sqlsrv_query($conexion, $query);
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $verArticulos[] = [
                    'idSolicitud' => $fila['id_Solicitud'],
                    'CodArticulo' => $fila['Cod_Articulo'],
                    'Articulo' => $fila['ARTICULO'],
                    'Cant' => $fila['Cant']                
                ];
            }
        } catch (Exception $e) {
            $verArticulos = 'Error SQL:' . $e;
        }    
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $verArticulos;
    }

    ///Validaciones de RTN NUEVO
    public static function validarRtnExiste($rtn) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();   
         $params = array($rtn);
        // $stmt = sqlsrv_query($conexion, $query, $params);
        // if ($stmt === false) {
        //     die(print_r(sqlsrv_errors(), true));
        // }
        // $existe = false;
        // $mensaje = '';
        // if (sqlsrv_fetch($stmt) === true) {
        //     $cantidadCIF = sqlsrv_get_field($stmt, 0);
        //     if ($cantidadCIF > 0) {
        //         $existe = true;
        //         $mensaje = 'RTN ya existe en View Clientes';
        //     }
        // }
        // sqlsrv_free_stmt($stmt); 
        $existe = false;
        $mensaje = '';
        $query = "SELECT COUNT(rtn_Cliente) AS Cantidad_de_RTN FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtn'";
        $stmt = sqlsrv_query($conexion, $query, $params);
        if ($stmt === false) {
            // Manejar errores de consulta
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_fetch($stmt) === true) {
            $cantidadRTN = sqlsrv_get_field($stmt, 0);
            if ($cantidadRTN > 0) {
                $existe = true;
                $mensaje = 'RTN ya existe el Cliente';
            }
        }
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexion);

        return array(
            'existe' => $existe,
            'mensaje' => $mensaje
        );
    }
    
    // Obtener todas las solicitudes .
    public static function obtenerSolicitudPDF($buscar)
    {
        $SolicitudesUsuario = null;
        try {
            $SolicitudesUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT id_Solicitud,
            cc.nombre_Cliente AS NombreCliente,
           t.servicio_Tecnico,
           telefono_cliente,
           EstadoAvance,
           s.Fecha_Creacion
       FROM [tbl_Solicitud] AS s
       INNER JOIN tbl_TipoServicio AS t ON t.id_TipoServicio = s.id_TipoServicio
       LEFT JOIN tbl_CarteraCliente AS cc ON cc.rtn_Cliente = s.rtn_clienteCartera 
       WHERE s.cod_Cliente IS NULL OR s.cod_Cliente = 'NULL' OR s.cod_Cliente = '' 
       and CONCAT( id_Solicitud,  cc.nombre_Cliente, t.servicio_Tecnico, 
               telefono_cliente, EstadoAvance, s.Fecha_Creacion) 
               LIKE '%' + '$buscar' + '%' 
       ORDER BY id_Solicitud;";

           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $SolicitudesUsuario[] = [
                    'id_Solicitud' => $fila['id_Solicitud'],
                    'Nombre' => $fila['NombreCliente'],
                    'servicio_Tecnico' => $fila['servicio_Tecnico'],
                    'telefono' => $fila['telefono_cliente'],
                    'EstadoAvance' => $fila['EstadoAvance'],
                    'Fecha_Creacion' => $fila['Fecha_Creacion']
                   
                ];
            }
        } catch (Exception $e) {
            $SolicitudesUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $SolicitudesUsuario;
    } 

    public static function insertarEvidenciaPDF($solicitud, $directorio_destino) {
        // Insertar evidencia en la base de datos
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "INSERT INTO tbl_EvidenciaGarantia (id_Solicitud, _url, fecha_Creacion) VALUES ('$solicitud', '$directorio_destino', GETDATE())";
        sqlsrv_query($consulta, $query);
    }
}

