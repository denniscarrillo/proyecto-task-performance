<?php
class Tarea
{
    public $idTarea;
    public $idEstadoAvance;
    public $iCarteraCliente;
    public $titulo;
    public $idCliente;
    public $idUsuario;
    public $fechaInicio;
    public $adjuntoFinalizacion;
    public $fechaFinalizacion;
    public $chatComentario;
    public $idClasificacionLead;
    public $idOrigenLead;
    public $estadoContacto;
    public $rubroComercial;
    public $razonSocial;
    public $estadoFinalizacion;
    //Campos de auditoria
    public $Creado_Por;
    public $Fecha_Creacion;
    public $Modificado_Por;
    public $Fecha_Modificacion;
    public $accionEvento;
    public $descripcionEvento;
    public $rtnCliente;
    public $telefono;
    public $correo;
    public $direccion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerTareas($idUser)
    {
        $tareasUsuario = null;
        try {
            $tareasUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT t.id_Tarea, t.id_EstadoAvance, t.titulo, e.descripcion, DATEDIFF(DAY, t.Fecha_Creacion, getdate()) as Dias_Antiguedad FROM tbl_vendedores_tarea AS vt
            INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea
            INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
            WHERE vt.id_usuario_vendedor = '$idUser' AND t.estado_Finalizacion IN('Pendiente', 'Reabierta')";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $tareasUsuario[] = [
                    'id' => $fila['id_Tarea'],
                    'idEstadoAvance' => $fila['id_EstadoAvance'],
                    'tipoTarea' => $fila['descripcion'],
                    'tituloTarea' => $fila['titulo'],
                    'diasAntiguedad' => $fila['Dias_Antiguedad']
                ];
            }
        } catch (Exception $e) {
            $tareasUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tareasUsuario;
    }

    public static function nuevaTarea($tarea)
    {
        try {
            $idTarea = null;
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $insert = "INSERT INTO tbl_Tarea (id_EstadoAvance, titulo, fecha_Inicio, estado_Finalizacion, Creado_Por, Fecha_Creacion) 
                            VALUES ('$tarea->idEstadoAvance','$tarea->titulo', GETDATE(), 'PENDIENTE', '$tarea->Creado_Por', GETDATE())"; 
            sqlsrv_query($abrirConexion, $insert);
            $query = "SELECT SCOPE_IDENTITY() AS id_Tarea";
            $resultado = sqlsrv_query($abrirConexion, $query);
            $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            $idTarea = $fila['id_Tarea'];
            $insertUsuarioTarea = "INSERT INTO tbl_vendedores_tarea (id_Tarea, id_usuario_vendedor, vend_Identificador) 
                                    VALUES ('$idTarea', '$tarea->idUsuario', 'Creador');";
            sqlsrv_query($abrirConexion, $insertUsuarioTarea);
            sqlsrv_close($abrirConexion); //Cerrar conexion
            return $idTarea;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
    }
    public static function obtenerEstadoClienteTarea($rtnCliente)
    {
        try {
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT estado_Cliente_Tarea 
            FROM tbl_tarea WHERE id_EstadoAvance = 4 AND RTN_Cliente = '$rtnCliente'";
            $estadoCliente = sqlsrv_query($abrirConexion, $select);
            while ($fila = sqlsrv_fetch_array($estadoCliente, SQLSRV_FETCH_ASSOC)) {
                $estado [] = [
                    'estadoClienteTarea' => $fila['estado_Cliente_Tarea']
                ];
            }
            return $estado;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }

    //Pertenece al modulo de comision.
    public static function clienteExistente($rtnCliente)
    {
        try {
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT COUNT(*) AS clienteExistente FROM tbl_tarea WHERE rtn_Cliente = '$rtnCliente'";
            $estadoCliente = sqlsrv_query($abrirConexion, $select);
            while ($fila = sqlsrv_fetch_array($estadoCliente, SQLSRV_FETCH_ASSOC)) {
                $estado [] = [
                    'clienteExistente' => $fila['clienteExistente']
                ];
            }
            if ($estado[0]['clienteExistente'] < 2 && $estado[0]['clienteExistente'] > 0) {
                $estado[0]['clienteExistente'] = 'Nuevo';
            } else if ($estado[0]['clienteExistente'] > 1) {
                $estado[0]['clienteExistente'] = 'Existente';
            }
            else{
                $estado[0]['clienteExistente'] = 'No Aplica Comision';
            }
            return $estado;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    
    public static function obtenerArticulos(){
        try{
            $articulos = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT * FROM tbl_ARTICULOS";
            $listaArticulos = sqlsrv_query($abrirConexion, $select);
            while($fila = sqlsrv_fetch_array($listaArticulos, SQLSRV_FETCH_ASSOC)){
                $articulos[] = [
                    'codArticulo' => $fila['CODARTICULO'],
                    'articulo' => $fila['ARTICULO'],
                    'detalleArticulo' =>$fila['DETALLE'],
                    'marcaArticulo' =>$fila['MARCA']
                ];
            }
            return $articulos;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerEstadosTarea(){
        try{
            $estadosTarea = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT * FROM tbl_estadoavance";
            $listaEstados = sqlsrv_query($abrirConexion, $select);
            while($fila = sqlsrv_fetch_array($listaEstados, SQLSRV_FETCH_ASSOC)){
                $estadosTarea[] = [
                   'idEstado' => $fila['id_EstadoAvance'],
                   'estado' => $fila['descripcion'] 
                ];
            }
            return $estadosTarea;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }

    public static function validarTipoCliente($rtn){
        try{
            $estadoCliente = false;
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectFacturas = "SELECT num_Factura FROM tbl_FacturasVenta WHERE rtn_Cliente = '$rtn'";
            $facturas = sqlsrv_query($abrirConexion, $selectFacturas);
            if(sqlsrv_has_rows($facturas)){
                $estadoCliente = true;         
            }
            sqlsrv_close($abrirConexion); //Cerrar conexion
            return $estadoCliente;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
    }
    
    public static function validarClienteExistenteCarteraCliente($rtn){
        try{
            $estadoCliente = false;
            $datosCliente = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT nombre_Cliente, telefono, correo, direccion FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtn'";
            $consulta = sqlsrv_query($abrirConexion, $selectCliente);
            if(sqlsrv_has_rows($consulta)){
                while($fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
                    $datosCliente = [
                        'nombre' => $fila['nombre_Cliente'],
                        'telefono' => $fila['telefono'],
                        'correo' => $fila['correo'],
                        'direccion' => $fila['direccion']
                    ];
                }
                sqlsrv_close($abrirConexion); //Cerrar conexion
                return $datosCliente;
            } else {
               return $estadoCliente;
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
    }
    public static function obtenerClientes(){
        try{
            $clientes = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT id_CarteraCliente, nombre_Cliente, rtn_Cliente, telefono, correo, direccion FROM tbl_CarteraCliente";
            $listaClientes = sqlsrv_query($abrirConexion, $select);
            while($fila = sqlsrv_fetch_array($listaClientes, SQLSRV_FETCH_ASSOC)){
                $clientes[] = [
                    'codCliente' => $fila['id_CarteraCliente'],
                    'nombre' => $fila['nombre_Cliente'],
                    'rtn' =>$fila['rtn_Cliente'],
                    'telefono' =>$fila['telefono'],
                    'correo' =>$fila['correo'],
                    'direccion' =>$fila['direccion']
                ];
            }
            return $clientes;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function agregarVendedoresTarea($idTarea, $idVendedores){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            foreach($idVendedores as $idVendedor){
                $id = $idVendedor['idVendedor'];
                $insertUsuarioTarea = "INSERT INTO tbl_vendedores_tarea (id_Tarea, id_usuario_vendedor, vend_Identificador) 
                                    VALUES ('$idTarea', '$id', 'Agregado');";
                sqlsrv_query($abrirConexion, $insertUsuarioTarea);
            }
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerVendedores($idTarea){
        try{
            $vendedores = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT us.id_Usuario, us.usuario, us.nombre_Usuario FROM tbl_ms_usuario us
            INNER JOIN tbl_MS_Roles ro ON us.id_Rol = ro.id_Rol
            WHERE ro.rol = 'VENDEDOR' AND us.id_Usuario NOT IN(SELECT us.id_Usuario FROM tbl_vendedores_tarea ta
            INNER JOIN tbl_MS_Usuario us ON ta.id_usuario_vendedor = us.id_Usuario
            WHERE id_Tarea = '$idTarea');";
            $listaVendedores = sqlsrv_query($abrirConexion, $select);
            while($fila = sqlsrv_fetch_array($listaVendedores , SQLSRV_FETCH_ASSOC)){
                $vendedores[] = [
                    'id' => $fila['id_Usuario'],
                    'usuario' => $fila['usuario'],
                    'nombre' =>$fila['nombre_Usuario']
                ];
            }
            return $vendedores;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function editarTarea($idTarea, $tipoTarea, $datosTarea){
        try{
            $update = '';
            $ModificadoPor = $datosTarea['ModificadoPor'];
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            //Valores a Setear
            $estadoCliente = $datosTarea['tipoCliente']; $titulo = $datosTarea['titulo']; $idRazon = $datosTarea['razon']; $idRubro = $datosTarea['rubro'];
            if(intval($tipoTarea) === 2){ //Tareas de tipo LEAD
                $idClasificacionLead = $datosTarea['clasificacionLead'];  $codCliente = $datosTarea['codCliente']; $rtn = $datosTarea['rtn']; $idOrigen = $datosTarea['origenLead'];
                //Actualizamos los datos de la tarea de tipo Lead
                if(isset($datosTarea['rtn']) && !empty($datosTarea['rtn'])){
                    $update = "UPDATE tbl_tarea SET RTN_Cliente = '$rtn', cod_Cliente = '$codCliente', titulo = '$titulo', estado_Cliente_Tarea = '$estadoCliente', 
                    id_ClasificacionLead = '$idClasificacionLead', id_OrigenLead = '$idOrigen', id_razon_Social = '$idRazon', id_rubro_Comercial ='$idRubro',
                    Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE() WHERE id_Tarea = '$idTarea';";
                } 
                else {
                    $update = "UPDATE tbl_tarea SET estado_Cliente_Tarea = '$estadoCliente', 
                    id_ClasificacionLead = '$idClasificacionLead', id_OrigenLead = '$idOrigen', titulo = '$titulo', id_razon_Social = '$idRazon', id_rubro_Comercial ='$idRubro',
                    Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE() WHERE id_Tarea = '$idTarea';";
                }
            } else { //Otros tipos de tarea
                $idClasificacionLead = $datosTarea['clasificacionLead'];  $codCliente = $datosTarea['codCliente']; $rtn = $datosTarea['rtn']; $idOrigen = $datosTarea['origenLead'];
                //Actualizamos los datos de la tarea
                if(isset($datosTarea['rtn']) && !empty($datosTarea['rtn'])){
                    $update = "UPDATE tbl_tarea SET RTN_Cliente = '$rtn', cod_Cliente = '$codCliente', titulo = '$titulo', estado_Cliente_Tarea = '$estadoCliente', id_razon_Social = '$idRubro', 
                    id_rubro_Comercial ='$idRazon', Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE() WHERE id_Tarea = '$idTarea';"; 
                } else {
                    $update = "UPDATE tbl_tarea SET estado_Cliente_Tarea = '$estadoCliente', titulo = '$titulo', id_razon_Social = '$idRazon', id_rubro_Comercial ='$idRubro'
                    , Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE() WHERE id_Tarea = '$idTarea';";
                }
            }
            sqlsrv_query($abrirConexion, $update);
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function guardarProductosInteres($idTarea, $productos){
        try{
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            foreach($productos as $producto){
                $idProducto = $producto['idProducto'];
                $cantProd = $producto['CantProducto'];
                $insert = "INSERT INTO tbl_productointeres (id_Tarea, id_Articulo, cantidad) 
                VALUES ('$idTarea', '$idProducto', '$cantProd');";
                sqlsrv_query($abrirConexion, $insert);
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
       sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function guardarFacturaTarea($idTarea, $evidencia, $accion, $creadoPor){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = '';
        if($accion == 0){
            $query = "INSERT INTO tbl_AdjuntoEvidencia (id_Tarea, evidencia, Creado_Por, fecha_Creacion)
                VALUES('$idTarea', '$evidencia', '$creadoPor', GETDATE())";
        } else {
            $query = "UPDATE tbl_AdjuntoEvidencia SET evidencia = '$evidencia', 
                Modificado_Por = '$creadoPor', fecha_Modificacion = GETDATE() WHERE id_Tarea = '$idTarea'";
        }
        sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion);
    }
    public static function obtenerClasificacionLead() {
        try{
            $clasificacion = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $query = "SELECT id_ClasificacionLead, nombre FROM tbl_ClasificacionLead;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $clasificacion[] = [
                    'id' => $fila['id_ClasificacionLead'],
                    'clasificacion' => $fila['nombre']
                ];
            }
            return $clasificacion;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerOrigenLead() {
        try{
            $origen = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $query = "SELECT id_OrigenLead, descripcion FROM tbl_OrigenLead;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado , SQLSRV_FETCH_ASSOC)) {
                $origen[] = [
                    'id' => $fila['id_OrigenLead'],
                    'origen' => $fila['descripcion']
                ];
            }
            return $origen;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function agregarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion, $Creado_Por){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $estadoContacto = 'EN PROCESO';
            $existeCliente = "SELECT rtn_Cliente FROM tbl_CarteraCliente WHERE rtn_Cliente = '$rtn'";
            $query = '';
            if(sqlsrv_has_rows(sqlsrv_query($abrirConexion, $existeCliente)) > 0){
                $query = "UPDATE tbl_CarteraCliente SET nombre_Cliente = '$nombre', telefono = '$telefono', correo = '$correo', direccion = '$direccion', 
                        Modificado_Por = '$Creado_Por', Fecha_Modificacion = GETDATE() WHERE rtn_Cliente = '$rtn'";
            } else {
                $query = "INSERT INTO tbl_CarteraCliente (nombre_Cliente, rtn_Cliente, telefono, correo, direccion, estadoContacto, Creado_Por, Fecha_Creacion) 
                VALUES('$nombre', '$rtn', '$telefono', '$correo', '$direccion', '$estadoContacto', '$Creado_Por', GETDATE());";
            }
            sqlsrv_query($abrirConexion, $query); 
            sqlsrv_close($abrirConexion); //Cerrar conexion
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
    }
    public static function obtenerCantTarea($FechaDesde, $FechaHasta) {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); // Abrimos la conexión a la DB.      
        // Consulta para obtener el conteo de tareas con id_EstadoAvance especificado
        $query = "SELECT id_EstadoAvance
        FROM tbl_Tarea where fecha_Inicio between '$FechaDesde' and '$FechaHasta';";
        $result = sqlsrv_query($abrirConexion, $query);  
        $cantTareas = array(); // Inicializamos la variable $rowCount en 0
        
        $contadorLlamada = 0; $contadorLead = 0; $contadorCotizacion = 0; $contadorVentas = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $idEstadoAvance = intval($row['id_EstadoAvance']);
            switch ($idEstadoAvance){
                case 1: {
                    $contadorLlamada++ ;
                    break;
                }
                case 2: {
                    $contadorLead++ ;
                    break;
                }
                case 3: {
                    $contadorCotizacion++ ;
                    break;
                }
                case 4: {
                    $contadorVentas++ ;
                    break;
                }
            }
        }
        $cantTareas = [
            "Llamadas" => $contadorLlamada,
            "Lead" => $contadorLead,
            "Cotizacion" => $contadorCotizacion,
            "Venta" => $contadorVentas
        ];
        sqlsrv_close($abrirConexion);   
        return $cantTareas;
    } 
    public static function obtenerTareaPorVendedor($idUsuario_Vendedor, $FechaDesde, $FechaHasta){
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); 
        $query = "SELECT  t.id_EstadoAvance  
                 FROM tbl_vendedores_tarea AS vt
                 INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea 
                 WHERE vt.id_usuario_vendedor = '$idUsuario_Vendedor' and t.fecha_Inicio 
                       between '$FechaDesde' and '$FechaHasta';";
        $ListaTareas = sqlsrv_query($abrirConexion, $query);  
        // $TareasXvendedor = array();
        $TotalLlamada = 0; $TotalLead = 0; $TotalCotizacion = 0; $TotalVentas = 0;
        while ($row = sqlsrv_fetch_array($ListaTareas, SQLSRV_FETCH_ASSOC)) {
            $idEstadoAvance = intval($row['id_EstadoAvance']);
            switch ($idEstadoAvance){
                case 1: {
                    $TotalLlamada++ ;
                    break;
                }
                case 2: {
                    $TotalLead++ ;
                    break;
                }
                case 3: {
                    $TotalCotizacion++ ;
                    break;
                }
                case 4: {
                    $TotalVentas++ ;
                    break;
                }
            }
        }
        $cantTareas = [
            "Llamadas" => $TotalLlamada,
            "Lead" => $TotalLead,
            "Cotizacion" => $TotalCotizacion,
            "Venta" => $TotalVentas
        ];
        sqlsrv_close($abrirConexion);   
        return $cantTareas;
    }
    public static function validarEstadoCliente($idTarea){
        $existeEstado = false;
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $selectTipoCliente = "SELECT estado_Cliente_Tarea FROM tbl_Tarea WHERE id_Tarea = '$idTarea'";
        $resultado = sqlsrv_query($abrirConexion, $selectTipoCliente);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        if(!empty($fila['estado_Cliente_Tarea'])){
            $existeEstado = true; 
        }
        sqlsrv_close($abrirConexion);   
        return $existeEstado;
    }
    public static function obtenerDatosClienteTarea($tipoTarea, $idTarea){
        $consultaDatos = '';
        $datosTarea = array();
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
                switch($tipoTarea){
                    case 0:{
                        $consultaDatos = "SELECT tr.titulo,tr.estado_Cliente_Tarea, tr.id_EstadoAvance, (SELECT evidencia FROM tbl_AdjuntoEvidencia WHERE id_Tarea = '$idTarea') as evidencia, tr.RTN_Cliente, cc.nombre_Cliente as NOMBRECLIENTE, 
                        cc.telefono as TELEFONO, cc.correo, cc.direccion as DIRECCION, rs.id_razon_Social, rc.id_rubro_Comercial FROM tbl_Tarea tr
                        INNER JOIN tbl_CarteraCliente cc ON tr.RTN_Cliente = cc.rtn_Cliente
						INNER JOIN tbl_razon_Social rs ON tr.id_razon_Social = rs.id_razon_Social
						INNER JOIN tbl_rubro_Comercial rc ON tr.id_rubro_Comercial = rc.id_rubro_Comercial
                        WHERE tr.id_Tarea = '$idTarea';";
                        break;
                    }
                    case 2:{
                        $consultaDatos = "SELECT tr.titulo,tr.estado_Cliente_Tarea, tr.id_EstadoAvance, (SELECT evidencia FROM tbl_AdjuntoEvidencia WHERE id_Tarea = '$idTarea') as evidencia, tr.id_ClasificacionLead , tr.id_OrigenLead,
                        tr.RTN_Cliente, cc.nombre_Cliente as NOMBRECLIENTE, cc.telefono as TELEFONO, cc.correo, cc.direccion as DIRECCION, rs.id_razon_Social, rc.id_rubro_Comercial FROM tbl_Tarea tr
                        INNER JOIN tbl_CarteraCliente cc ON tr.RTN_Cliente = cc.rtn_Cliente
						INNER JOIN tbl_razon_Social rs ON tr.id_razon_Social = rs.id_razon_Social
						INNER JOIN tbl_rubro_Comercial rc ON tr.id_rubro_Comercial = rc.id_rubro_Comercial
                        WHERE tr.id_Tarea = '$idTarea';";
                        break;
                    }
                }
            $resultado2 = sqlsrv_query($abrirConexion, $consultaDatos);
            $datosTarea = sqlsrv_fetch_array($resultado2, SQLSRV_FETCH_ASSOC);
            
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $datosTarea;
    }
    public static function editarNuevoClienteTarea($editarClienteTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $rtnCliente = $editarClienteTarea->rtnCliente;
        $telefono = $editarClienteTarea->telefono;
        $correo = $editarClienteTarea->correo;
        $direccion = $editarClienteTarea->direccion;
        $modificadoPor = $editarClienteTarea->Modificado_Por;
        $update = "UPDATE tbl_CarteraCliente SET telefono = '$telefono', correo = '$correo', direccion = '$direccion', 
        Modificado_Por = '$modificadoPor', Fecha_Modificacion = GETDATE() WHERE rtn_Cliente='$rtnCliente';";
        sqlsrv_query($conexion, $update);
        sqlsrv_close($conexion); //Cerrar conexion
    }
    public static function obtenerRtnClienteTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $estadoRtn = "false";
        $consulta = "SELECT RTN_Cliente FROM tbl_tarea WHERE id_Tarea='$idTarea';";
        $ejecutar = sqlsrv_query($conexion, $consulta);
        $fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC);
        if($fila['RTN_Cliente'] != null || $fila['RTN_Cliente'] !=''){
            $estadoRtn = "true";
        }
        sqlsrv_close($conexion);
        return $estadoRtn;
    }
    public static function obtenerDatos($idTarea, $estadoCliente){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $select = "SELECT cc.rtn_Cliente AS RTN, cc.nombre_Cliente AS NOMBRE, cc.telefono AS TELEFONO, us.nombre_Usuario AS VENDEDOR, us.telefono AS TELVENDEDOR FROM tbl_CarteraCliente cc
        INNER JOIN tbl_Tarea tr ON cc.rtn_Cliente = tr.RTN_Cliente
        INNER JOIN tbl_MS_Usuario us ON us.usuario = tr.Creado_Por
        WHERE tr.id_Tarea = '$idTarea';";
        $ejecutar = sqlsrv_query($conexion, $select);
        $fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC);
        //Obtenemos el valor del parametro dias vigencia cotizacion y lo agregamos al array datos del cliente para cotizacion
        $ejecutarQuery = sqlsrv_query($conexion, "SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'DIAS VIGENCIA COTIZACION';");
        $parametroCotizacion = sqlsrv_fetch_array($ejecutarQuery, SQLSRV_FETCH_ASSOC);
        $fila +=[
            "vigencia"=>$parametroCotizacion['valor']
        ];
        sqlsrv_close($conexion);
        return $fila;
    }
    public static function nuevaCotizacion($nuevaCotizacion, $creadoPor){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idTarea = $nuevaCotizacion['idTarea'];
        $validez = intval($nuevaCotizacion['validez']);
        $subTotal = $nuevaCotizacion['subTotal'];
        $descuento = $nuevaCotizacion['descuento'];
        $subDescuento = $nuevaCotizacion['subDescuento'];
        $isv = $nuevaCotizacion['isv'];
        $totalCotizacion = $nuevaCotizacion['total'];
        $insert = "INSERT INTO tbl_CotizacionTarea (estado_Cotizacion, id_Tarea, validez, subTotal, descuento, subDescuento, isv, total_Cotizacion, Creado_Por, Fecha_Creacion)
        VALUES ('VIGENTE', '$idTarea', '$validez', '$subTotal', '$descuento', '$subDescuento', '$isv', '$totalCotizacion', '$creadoPor', GETDATE());";
        sqlsrv_query($conexion, $insert);
        $idCotizacion = sqlsrv_fetch_array(sqlsrv_query($conexion, "SELECT SCOPE_IDENTITY() AS id_Cotizacion"), SQLSRV_FETCH_ASSOC);
        sqlsrv_close($conexion);
        return $idCotizacion;
    }
    public static function productosCotizacion($idCotizacion, $productosCotizacion, $creadoPor){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        foreach($productosCotizacion as $producto){
            $idProducto = $producto['id']; $item = $producto['item'];
            $idPrecio = $producto['idPrecio']; $cantidad = $producto['cantidad']; $total = $producto['total'];
            $insert = "INSERT INTO tbl_ProductosCotizacion (id_Cotizacion, id_Producto, item, id_precio, cantidad, total, Creado_Por, Fecha_Creacion)
                VALUES ('$idCotizacion', '$idProducto', '$item', '$idPrecio', '$cantidad', '$total', '$creadoPor', GETDATE());";
            sqlsrv_query($conexion, $insert);
        }
        sqlsrv_close($conexion);
    }

    public static function obtenerDatosCotizacion($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $datosCotizacion = array();
        $selectCot = "SELECT id_Cotizacion, estado_Cotizacion, subTotal, descuento, subDescuento, isv, total_Cotizacion
        FROM tbl_CotizacionTarea
        WHERE id_Cotizacion = (SELECT MAX(id_Cotizacion) FROM tbl_CotizacionTarea WHERE id_Tarea = '$idTarea');";
        $resultCot = sqlsrv_query($conexion, $selectCot);
        if(sqlsrv_has_rows($resultCot)){
            $fila = sqlsrv_fetch_array($resultCot, SQLSRV_FETCH_ASSOC);
            $datosCotizacion = [
                'detalle' => $fila
            ];
            $idCot = intval($fila['id_Cotizacion']);
            $selectCotProductos = "SELECT pct.id_Producto ,pc.item, pct.descripcion, pct.marca, pc.cantidad, pp.id_Precio, pp.precio, pc.total FROM tbl_ProductosCotizacion pc 
            INNER JOIN tbl_ProductosCotizados pct ON pc.id_Producto = pct.id_Producto
            INNER JOIN tbl_PreciosProductos pp ON pct.id_Producto = pp.id_Producto
            WHERE pp.estado_Precio = 'Activo' AND pc.id_Cotizacion = '$idCot';";
            $resultCot = sqlsrv_query($conexion, $selectCotProductos);
            $productos = array();
            while($fila = sqlsrv_fetch_array($resultCot, SQLSRV_FETCH_ASSOC)){
                $productos[] = [
                    'id' => $fila['id_Producto'],
                    'item' => $fila['item'],
                    'descripcion' => $fila['descripcion'],
                    'marca' => $fila['marca'],
                    'cantidad' => $fila['cantidad'],
                    'precio' => $fila['precio'],
                    'idPrecio' => $fila['id_Precio'],
                    'total' => $fila['total']
                ];
            }
            $datosCotizacion += [
                'productos' => $productos
            ];
        }
        sqlsrv_close($conexion);
        return $datosCotizacion;
    }
    public static function almacenarProductoCotizacion($producto){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        if(!empty($producto)){
            $marca = $producto['marca']; $descripcion = $producto['descripcion'];
            $insertProducto = "INSERT INTO tbl_ProductosCotizados (descripcion, marca) VALUES ('$descripcion', '$marca')";
            sqlsrv_query($conexion, $insertProducto);
            $selectId = "SELECT SCOPE_IDENTITY() AS id_Producto";
            $idProduct = sqlsrv_fetch_array(sqlsrv_query($conexion, $selectId ), SQLSRV_FETCH_ASSOC);
        }
        sqlsrv_close($conexion);
        return intval($idProduct['id_Producto']);
    }
    public static function obtenerProductosCotizados(){
        try{
            $productos = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT pc.id_Producto, pc.descripcion, pc.marca, pp.precio, pp.id_Precio FROM tbl_ProductosCotizados pc
            INNER JOIN tbl_PreciosProductos pp ON pc.id_Producto = pp.id_Producto
            WHERE pp.estado_Precio = 'Activo';";
            $listaProductos = sqlsrv_query($abrirConexion, $select);
            while($fila = sqlsrv_fetch_array($listaProductos, SQLSRV_FETCH_ASSOC)){
                $productos[] = [
                    'idProducto' => $fila['id_Producto'],
                    'producto' => $fila['descripcion'],
                    'marca' =>$fila['marca'],
                    'precio' => $fila['precio'],
                    'id_Precio' => $fila['id_Precio']
                ];
            }
            return $productos;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function insertarPrecioProducto($idProducto, $precio){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        if(!empty($idProducto)){
            $insert = "INSERT INTO tbl_PreciosProductos (id_Producto, precio, estado_Precio) VALUES ('$idProducto', '$precio', 'Activo')";
            sqlsrv_query($conexion, $insert);
        }
        sqlsrv_close($conexion);
    }
    public static function anularCotizacion($idCotizacion, $moficadoPor){
        $estado = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_CotizacionTarea  SET estado_Cotizacion = 'Anulada', Modificado_Por = '$moficadoPor', 
                Fecha_Modificacion = GETDATE() WHERE id_Cotizacion = '$idCotizacion';";
        if(sqlsrv_rows_affected(sqlsrv_query($conexion, $query)) == 1) {
            $estado = true;
        }
        sqlsrv_close($conexion);
        return $estado;
    }
    public static function calcularVencimientoCotizacion($idCotizacion){
        $estado = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT DATEDIFF(day, Fecha_Creacion, GETDATE()) AS dias_Transcurridos, 
                    (SELECT valor FROM tbl_MS_Parametro WHERE parametro = 'DIAS VIGENCIA COTIZACION') AS vigencia
                        FROM tbl_CotizacionTarea WHERE id_Cotizacion = '$idCotizacion';";
        $fila = sqlsrv_fetch_array(sqlsrv_query($conexion, $query));
        if(intval($fila['dias_Transcurridos']) > intval($fila['vigencia'])){
            $estado = true;
        }
        sqlsrv_close($conexion);
        return $estado;
    }
    public static function vencimientoEstadoCotizacion($idCotizacion){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_CotizacionTarea SET estado_Cotizacion = 'Vencida' WHERE id_Cotizacion = '$idCotizacion'";
        sqlsrv_query($conexion,$query);
        sqlsrv_close($conexion);
    }

    public static function obtenerCotizacionesUsuario($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $select = '';
        $cotizaciones = array();
        if($usuario == 'SUPERADMIN'){
            $select = "SELECT ROW_NUMBER() OVER(ORDER BY ct.id_Cotizacion ASC) AS Num, ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente AS nombre_Cliente, ct.subDescuento, ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion 
            FROM tbl_CotizacionTarea ct
            INNER JOIN tbl_Tarea ta ON ct.id_Tarea = ta.id_Tarea
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ct.Creado_Por = us.usuario;";
                $ejecutar = sqlsrv_query($conexion, $select);
                if(sqlsrv_has_rows($ejecutar)){
                    while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                        $cotizaciones[] = [
                            'item' => $fila['Num'],
                            'id' => $fila['id_Cotizacion'],
                            'creadoPor' => $fila['nombre_Usuario'],
                            'cliente' =>$fila['nombre_Cliente'],
                            'subDescuento' => $fila['subDescuento'],
                            'impuesto' => $fila['isv'],
                            'total' => $fila['total_Cotizacion'],
                            'estado' => $fila['estado_Cotizacion']
                        ];
                    }
                }
            $select = "  SELECT ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente AS nombre_Cliente, ct.subDescuento, ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion 
            FROM tbl_CotizacionTarea ct
            INNER JOIN tbl_Tarea ta ON ct.id_Tarea = ta.id_Tarea
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente COLLATE Latin1_General_CS_AI
            INNER JOIN tbl_MS_Usuario us ON ct.Creado_Por = us.usuario
            WHERE cc.rtn_Cliente IN(SELECT rtn_Cliente FROM tbl_Tarea);";
                $ejecutar = sqlsrv_query($conexion, $select);
                if(sqlsrv_has_rows($ejecutar)){
                    while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                        $cotizaciones[] = [
                            'id' => $fila['id_Cotizacion'],
                            'creadoPor' => $fila['nombre_Usuario'],
                            'cliente' =>$fila['nombre_Cliente'],
                            'subDescuento' => $fila['subDescuento'],
                            'impuesto' => $fila['isv'],
                            'total' => $fila['total_Cotizacion'],
                            'estado' => $fila['estado_Cotizacion']
                        ];
                    }
                }
        }else{
            $select = "SELECT ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente AS nombre_Cliente, ct.subDescuento, ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion 
                FROM tbl_CotizacionTarea ct
                INNER JOIN tbl_Tarea ta ON ct.id_Tarea = ta.id_Tarea
                INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
                INNER JOIN tbl_MS_Usuario us ON ct.Creado_Por = us.usuario
                WHERE ct.Creado_Por = '$usuario';";
                $ejecutar = sqlsrv_query($conexion, $select);
                if(sqlsrv_has_rows($ejecutar)){
                    while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                        $cotizaciones[] = [
                            'id' => $fila['id_Cotizacion'],
                            'creadoPor' => $fila['nombre_Usuario'],
                            'cliente' =>$fila['nombre_Cliente'],
                            'subDescuento' => $fila['subDescuento'],
                            'impuesto' => $fila['isv'],
                            'total' => $fila['total_Cotizacion'],
                            'estado' => $fila['estado_Cotizacion']
                        ];
                    }
                }
            $select = "SELECT ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente AS nombre_Cliente, ct.subDescuento, ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion 
            FROM tbl_CotizacionTarea ct
            INNER JOIN tbl_Tarea ta ON ct.id_Tarea = ta.id_Tarea
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente COLLATE Latin1_General_CS_AI
            INNER JOIN tbl_MS_Usuario us ON ct.Creado_Por = us.usuario
            WHERE ct.Creado_Por = '$usuario' AND cc.rtn_Cliente IN(SELECT cod_Cliente FROM tbl_Tarea);";
                $ejecutar = sqlsrv_query($conexion, $select);
                if(sqlsrv_has_rows($ejecutar)){
                    while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                        $cotizaciones[] = [
                            'id' => $fila['id_Cotizacion'],
                            'creadoPor' => $fila['nombre_Usuario'],
                            'cliente' =>$fila['nombre_Cliente'],
                            'subDescuento' => $fila['subDescuento'],
                            'impuesto' => $fila['isv'],
                            'total' => $fila['total_Cotizacion'],
                            'estado' => $fila['estado_Cotizacion']
                        ];
                    }
                }
        }
        sqlsrv_close($conexion);
        return $cotizaciones;
    }

    public static function obtenerCotizacionesUsuarioPDF($usuario, $buscar){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $select = '';
        $cotizaciones = array();
        if($usuario == 'SUPERADMIN'){
            $select = "SELECT ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente COLLATE Latin1_General_CI_AI AS nombre_Cliente, ct.subDescuento, ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion 
            FROM tbl_CotizacionTarea ct
            INNER JOIN tbl_Tarea ta ON ct.id_Tarea = ta.id_Tarea
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ct.Creado_Por = us.usuario
            WHERE CONCAT(ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente, ct.subDescuento, ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion) 
            LIKE '%' + '' + '%' 
            ORDER BY id_Cotizacion ASC;";
                $ejecutar = sqlsrv_query($conexion, $select);
                if(sqlsrv_has_rows($ejecutar)){
                    while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                        $cotizaciones[] = [
                            'id' => $fila['id_Cotizacion'],
                            'creadoPor' => $fila['nombre_Usuario'],
                            'cliente' =>$fila['nombre_Cliente'],
                            'subDescuento' => $fila['subDescuento'],
                            'impuesto' => $fila['isv'],
                            'total' => $fila['total_Cotizacion'],
                            'estado' => $fila['estado_Cotizacion']
                        ];
                    }
                }            
        }else{
            $select = "SELECT ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente AS nombre_Cliente, ct.subDescuento, 
            ct.isv, ct.total_Cotizacion, ct.estado_Cotizacion 
            FROM tbl_CotizacionTarea ct
            INNER JOIN tbl_Tarea ta ON ct.id_Tarea = ta.id_Tarea
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ct.Creado_Por = us.usuario
            WHERE ct.Creado_Por = '$usuario' 
            AND CONCAT(ct.id_Cotizacion, us.nombre_Usuario, cc.nombre_Cliente, ct.subDescuento, ct.isv, 
            ct.total_Cotizacion, ct.estado_Cotizacion) 
            LIKE '%' + '$buscar' + '%' 
            ORDER BY id_Cotizacion;";
                $ejecutar = sqlsrv_query($conexion, $select);
                if(sqlsrv_has_rows($ejecutar)){
                    while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                        $cotizaciones[] = [
                            'id' => $fila['id_Cotizacion'],
                            'creadoPor' => $fila['nombre_Usuario'],
                            'cliente' =>$fila['nombre_Cliente'],
                            'subDescuento' => $fila['subDescuento'],
                            'impuesto' => $fila['isv'],
                            'total' => $fila['total_Cotizacion'],
                            'estado' => $fila['estado_Cotizacion']
                        ];
                    }
                }          
        }
        sqlsrv_close($conexion);
        return $cotizaciones;
    }

    public static function obtenerCotizacionXId($idCotizacion){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $datosCotizacion = array();
        $selectCot = "SELECT id_Cotizacion,estado_Cotizacion,id_Tarea,validez,subTotal,descuento,subDescuento,isv
        ,total_Cotizacion,Creado_Por,Fecha_Creacion,Modificado_Por,Fecha_Modificacion
        FROM tbl_CotizacionTarea where id_Cotizacion = $idCotizacion";
        $resultCot = sqlsrv_query($conexion, $selectCot);
        if(sqlsrv_has_rows($resultCot)){
            $fila = sqlsrv_fetch_array($resultCot, SQLSRV_FETCH_ASSOC);
            $datosCotizacion = [
                'detalleC' => $fila
            ];
            $selectCotProductos = "SELECT pc.id_Producto ,pc.item, pct.descripcion, pct.marca, pc.cantidad, pp.id_Precio, pp.precio, pc.total 
            FROM tbl_ProductosCotizacion pc 
            INNER JOIN tbl_ProductosCotizados pct ON pc.id_Producto = pct.id_Producto
            INNER JOIN tbl_PreciosProductos pp ON pct.id_Producto = pp.id_Producto
            WHERE  pc.id_Cotizacion = '$idCotizacion';";
            $resultCot = sqlsrv_query($conexion, $selectCotProductos);
            $productos = array();
            while($fila = sqlsrv_fetch_array($resultCot, SQLSRV_FETCH_ASSOC)){
                $productos[] = [
                    'id' => $fila['id_Producto'],
                    'item' => $fila['item'],
                    'descripcion' => $fila['descripcion'],
                    'marca' => $fila['marca'],
                    'cantidad' => $fila['cantidad'],
                    'precio' => $fila['precio'],
                    'idPrecio' => $fila['id_Precio'],
                    'total' => $fila['total']
                ];
            }
            $datosCotizacion += [
                'productos' => $productos
            ];
        }
        sqlsrv_close($conexion);
        return $datosCotizacion;
    }

    public static function obtenerProductosInteres($idTarea){
        $productos = array();
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT pi.id_Articulo, va.ARTICULO AS descripcion, va.MARCA, pi.cantidad FROM tbl_ARTICULOS va 
        INNER JOIN tbl_ProductoInteres pi ON pi.id_Articulo = va.CODARTICULO WHERE pi.id_Tarea = '$idTarea'";
        $result = sqlsrv_query($conexion, $query);
        if(sqlsrv_has_rows($result)) {
            while($fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                $productos [] = [
                    'id' => $fila['id_Articulo'],
                    'descripcion' => $fila['descripcion'],
                    'marca' => $fila['MARCA'],
                    'cantidad' => $fila['cantidad']
                ];
            }
        }
        sqlsrv_close($conexion);
        return $productos;
    }
    public static function cambiarEstadoTarea($idTarea, $newEstado, $usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $update = sqlsrv_query($conexion, "UPDATE tbl_Tarea SET id_EstadoAvance = '$newEstado', Modificado_Por = '$usuario', Fecha_Modificacion = GETDATE() WHERE id_Tarea = '$idTarea'");
        if(sqlsrv_rows_affected($update) > 0) {
            sqlsrv_query($conexion, "INSERT INTO tbl_historial_estado_tarea VALUES('$idTarea', '$newEstado', '$usuario', GETDATE())");
        }
        sqlsrv_close($conexion);
    }
    
    public static function obtenerEstadoTarea($idTarea){
        $estados = array();
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_estadoAvance, titulo FROM tbl_Tarea WHERE id_Tarea = '$idTarea'";
        $fila = sqlsrv_fetch_array(sqlsrv_query($conexion, $query), SQLSRV_FETCH_ASSOC);
        sqlsrv_close($conexion);
        return $fila;
    }
    public static function obtenerIdCotizacionTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idCotizacion = 0;
        $query = "SELECT TOP 1 id_Cotizacion FROM tbl_CotizacionTarea WHERE id_Tarea = '$idTarea' ORDER BY id_Cotizacion DESC;";
        $ejecutar = sqlsrv_query($conexion, $query);
        if(sqlsrv_has_rows($ejecutar) > 0){
            $cotizacion = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC);
            $idCotizacion = $cotizacion['id_Cotizacion'];
        }
        sqlsrv_close($conexion);
        return $idCotizacion;
    }
    public static function finalizarTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $estadoUpdate = false;
        $query = "UPDATE tbl_Tarea SET estado_Finalizacion = 'FINALIZADA', fecha_Finalizacion = GETDATE() WHERE id_Tarea = '$idTarea';";
        if(sqlsrv_rows_affected(sqlsrv_query($conexion, $query)) > 0){
            $estadoUpdate = true;
        }
        sqlsrv_close($conexion);
        return $estadoUpdate;
    }
    public static function obtenerTareaFinalizada($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $existeTarea = 0;
        $query = "SELECT estado_Finalizacion FROM tbl_Tarea WHERE id_Tarea = '$idTarea';";
        $ejecutar = sqlsrv_query($conexion, $query);
        if(sqlsrv_has_rows($ejecutar)){
            $tarea = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC);
            $existeTarea = $tarea['estado_Finalizacion'];
        }
        sqlsrv_close($conexion);
        return $existeTarea;
    }
    public static function reabrirTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $estadoReabierto = false;
        $query ="UPDATE tbl_Tarea SET estado_Finalizacion = 'REABIERTA' WHERE id_Tarea = '$idTarea';";
        if(sqlsrv_rows_affected(sqlsrv_query($conexion, $query)) > 0){
            $estadoReabierto = true;
        }
        sqlsrv_close($conexion);
        return $estadoReabierto;
    }
    public static function validarSiExisteEvidencia($evidencia){
        try{
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $query = "SELECT id_Tarea, Creado_Por FROM tbl_AdjuntoEvidencia WHERE evidencia = '$evidencia'";
            $result = sqlsrv_query($abrirConexion, $query);
            $userV = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
            if(sqlsrv_has_rows($result) > 0){
                $estado = [
                    'estado' =>  true,
                    'nTarea' => $userV['id_Tarea'],
                    'vendedor' => $userV['Creado_Por']
                ];
            } else {
                $estado = [
                    'estado' =>  false
                ];
            }
            sqlsrv_close($abrirConexion); //Cerrar conexion
            return $estado;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
    }
    public static function obtenerLlaveUnicaClienteTarea($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $llave = array();
        $query = "SELECT RTN_Cliente, cod_Cliente FROM tbl_Tarea WHERE id_Tarea = '$idTarea'";
        $result = sqlsrv_query($conexion, $query);
        if(sqlsrv_has_rows($result) > 0){
            $llave = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        }
        sqlsrv_close($conexion);
        return $llave;
    }
    public static function validarFacturaEvidencia($cif, $codCliente, $numFactura){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $existe = false;
        $query = "SELECT NUMFACTURA FROM View_FACTURASVENTA WHERE CODCLIENTE
        = (SELECT CODCLIENTE FROM view_clientes WHERE CIF = '$cif' and CODCLIENTE = '$codCliente')  and NUMFACTURA = '$numFactura'";
        if(sqlsrv_has_rows(sqlsrv_query($conexion, $query)) > 0){
            $existe = true;
        }
        sqlsrv_close($conexion);
        return $existe;
    }
    public static function obtenerTipoCliente($idTarea){
        $tipoCliente = null;
        try{
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT TRIM(estado_Finalizacion) AS tipo_cliente FROM tbl_Tarea WHERE id_Tarea = '$idTarea'";
            $consulta = sqlsrv_query($abrirConexion, $selectCliente);
            if(sqlsrv_has_rows($consulta)){
                $tipoCliente = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC);
                $tipoCliente = $tipoCliente['tipo_cliente'];
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tipoCliente;
    }
    public static function obtenerRazonSocial(){
        try{
            $razon = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $query = "SELECT id_razon_Social, razon_Social FROM tbl_razon_Social;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $razon[] = [
                    'id' => $fila['id_razon_Social'],
                    'razonSocial' => $fila['razon_Social']
                ];
            }
            return $razon;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerRubroComercial(){
        try{
            $rubro = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $query = "SELECT id_rubro_Comercial, rubro_Comercial FROM tbl_rubro_Comercial;";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $rubro[] = [
                    'id' => $fila['id_rubro_Comercial'],
                    'rubroComercial' => $fila['rubro_Comercial']
                ];
            }
            return $rubro;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
}