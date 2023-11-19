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
            CASE
                WHEN cc.nombre_Cliente IS NOT NULL AND cc.nombre_Cliente <> '' THEN cc.nombre_Cliente COLLATE Modern_Spanish_CI_AS
                ELSE c.NOMBRECLIENTE COLLATE Modern_Spanish_CI_AS
            END AS NombreCliente,
            t.servicio_Tecnico,
            telefono_cliente,
            EstadoAvance,
            s.Fecha_Creacion
            FROM [tbl_Solicitud] as s
            INNER JOIN tbl_TipoServicio as t ON t.id_TipoServicio = s.id_TipoServicio
            LEFT JOIN View_Clientes as c ON c.CIF COLLATE Modern_Spanish_CI_AS = s.rtn_cliente COLLATE Modern_Spanish_CI_AS
            LEFT JOIN tbl_CarteraCliente as cc ON cc.rtn_Cliente = s.rtn_clienteCartera ;";

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


    public static function actualizarEstadoSolicitud($nuevaSolicitud){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $idSolicitud=$nuevaSolicitud->idSolicitud;
            $EstadoSolicitud=$nuevaSolicitud->EstadoSolicitud;
            $MotivoCancelacion=$nuevaSolicitud->MotivoCancelacion;
            $modificadoPor=$nuevaSolicitud->modificadoPor;
            // date_default_timezone_set('America/Tegucigalpa'); 
            // $fechaModificado = date("Y-m-d h:i:s");
            $query ="UPDATE tbl_Solicitud SET EstadoSolicitud='$EstadoSolicitud', motivo_cancelacion = '$MotivoCancelacion', 
            Modificado_Por='$modificadoPor', Fecha_Modificacion = GETDATE()
            WHERE id_Solicitud='$idSolicitud';";
            $nuevaSolicitud = sqlsrv_query($abrirConexion, $query);
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
        CASE
        WHEN cc.nombre_Cliente IS NOT NULL AND cc.nombre_Cliente <> '' THEN cc.nombre_Cliente COLLATE Modern_Spanish_CI_AS
          ELSE c.NOMBRECLIENTE COLLATE Modern_Spanish_CI_AS
        END AS NombreCliente
        ,descripcion,t.servicio_Tecnico,s.correo,telefono_cliente,ubicacion_instalacion,EstadoAvance
        ,EstadoSolicitud,motivo_cancelacion,s.Creado_Por,s.Fecha_Creacion,s.Modificado_Por,s.Fecha_Modificacion
        FROM [tbl_Solicitud] as s
        inner join tbl_TipoServicio as t on t.id_TipoServicio = s.id_TipoServicio
        LEFT join View_Clientes as c on c.CIF COLLATE Modern_Spanish_CI_AS = s.rtn_cliente COLLATE Modern_Spanish_CI_AS
        LEFT join tbl_CarteraCliente as cc on cc.rtn_Cliente = s.rtn_clienteCartera
        Where id_Solicitud = $idSolicitud;";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $datosVerSolicitudes = [
            'idSolicitud' => $fila['id_Solicitud'],
            'idFactura' => $fila['idFactura'],
            'rtnCliente' => $fila['rtn_cliente'],
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
        $rtnCliente = $nuevaSolicitud->rtnCliente;
        $rtnClienteCartera = $nuevaSolicitud->rtnClienteC;
        $Descripcion = $nuevaSolicitud->descripcion;
        $TipoServicio = $nuevaSolicitud->tipoServicio;
        $Correo = $nuevaSolicitud->correo;
        $telefono = $nuevaSolicitud->telefono;
        $ubicacion = $nuevaSolicitud->ubicacion;
        $EstadoAvance = $nuevaSolicitud->estadoAvance;
        $EstadoSolicitud = $nuevaSolicitud->estadoSolicitud;
        $CreadoPor = $nuevaSolicitud->creadoPor;
        
        $query = "INSERT INTO tbl_Solicitud(idFactura, rtn_cliente, rtn_clienteCartera, descripcion, 
        id_TipoServicio, correo, telefono_cliente, ubicacion_instalacion, EstadoAvance, EstadoSolicitud, 
        Creado_Por, Fecha_Creacion) 
        VALUES ('$idFactura','$rtnCliente', '$rtnClienteCartera', '$Descripcion', '$TipoServicio', '$Correo',
        '$telefono', '$ubicacion', '$EstadoAvance', '$EstadoSolicitud','$CreadoPor', GETDATE());";
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
            INNER JOIN view_ARTICULOS as a on a.CODARTICULO = p.Cod_Articulo
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

    public static function validarRtnExiste($rtn) {
        $validarRtnExiste= false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT rtn_Cliente FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtn'";
        $rtnCliente = sqlsrv_query($conexion, $query);
        $query2 = "SELECT rtn_Cliente FROM tbl_CarteraCliente WHERE (rtn_Cliente= '$rtn' AND rtn_Cliente IS NOT NULL AND rtn_Cliente != '')
        OR (rtn_Cliente IS NOT NULL AND rtn_Cliente!= '' AND '$rtn' IS NULL)";
        $rtnCliente2 = sqlsrv_query($conexion, $query2);
        $existe = sqlsrv_has_rows($rtnCliente);
        $existe2 = sqlsrv_has_rows($rtnCliente2);
        if($existe || $existe2){
            $validarRtnExiste= true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $validarRtnExiste;
    }

    // Obtener todas las solicitudes .
    public static function obtenerSolicitudPDF($buscar)
    {
        $SolicitudesUsuario = null;
        try {
            $SolicitudesUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT 
            id_Solicitud,
            CASE
                WHEN cc.nombre_Cliente IS NOT NULL AND cc.nombre_Cliente <> '' THEN cc.nombre_Cliente COLLATE Modern_Spanish_CI_AS
                ELSE c.NOMBRECLIENTE COLLATE Modern_Spanish_CI_AS
            END AS NombreCliente, t.servicio_Tecnico, telefono_cliente, EstadoAvance, s.Fecha_Creacion
        FROM 
            tbl_Solicitud as s
        INNER JOIN tbl_TipoServicio as t ON t.id_TipoServicio = s.id_TipoServicio
        LEFT JOIN View_Clientes as c ON c.CIF COLLATE Modern_Spanish_CI_AS = s.rtn_cliente COLLATE Modern_Spanish_CI_AS
        LEFT JOIN tbl_CarteraCliente as cc ON cc.rtn_Cliente = s.rtn_clienteCartera 
        WHERE CONCAT( id_Solicitud,  cc.nombre_Cliente, c.NOMBRECLIENTE, t.servicio_Tecnico, 
                telefono_cliente, EstadoAvance, s.Fecha_Creacion) 
                COLLATE Modern_Spanish_CI_AS LIKE '%' + '$buscar' + '%' COLLATE Modern_Spanish_CI_AS 
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
    
}

