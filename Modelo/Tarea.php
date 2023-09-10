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
    public $rubroComercial;
    public $razonSocial;
    public $estadoFinalizacion;
    //Campos de auditoria
    public $Creado_Por;
    public $Fecha_Creacion;
    public $Modificado_Por;
    public $Fecha_Modificacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerTareas($idUser)
    {
        $tareasUsuario = null;
        try {
            $tareasUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT t.id_Tarea, t.id_EstadoAvance, t.titulo, t.fecha_Inicio, e.descripcion  FROM tbl_vendedores_tarea AS vt
            INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea
            INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
            WHERE vt.id_usuario_vendedor = '$idUser';";
            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $tareasUsuario[] = [
                    'id' => $fila['id_Tarea'],
                    'idEstadoAvance' => $fila['id_EstadoAvance'],
                    'tipoTarea' => $fila['descripcion'],
                    'tituloTarea' => $fila['titulo'],
                    'fechaInicio' => $fila['fecha_Inicio'],
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
            $insert = "INSERT INTO `tbl_tarea` (`id_EstadoAvance`, `titulo`, `fecha_Inicio`, `Creado_Por`, `Fecha_Creacion`) 
                            VALUES ('$tarea->idEstadoAvance','$tarea->titulo', 
                                    '$tarea->fechaInicio', '$tarea->Creado_Por', '$tarea->fechaInicio')"; 
            $ejecutar_insert = sqlsrv_query($abrirConexion, $insert);
            $idTarea = mysqli_insert_id($abrirConexion);
            $insertUsuarioTarea = "INSERT INTO `tbl_vendedores_tarea` (`id_Tarea`, `id_usuario_vendedor`) 
                                    VALUES ('$idTarea', '$tarea->idUsuario');";
            $ejecutar_insert = sqlsrv_query($abrirConexion, $insertUsuarioTarea);
            /* $abrirConexion->query($insertUsuarioTarea); */
            
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
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
    public static function clienteExistente($rtnCliente)
    {
        try {
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT COUNT(*) AS 'clienteExistente' FROM tbl_tarea WHERE RTN_Cliente = '$rtnCliente'";
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
    public static function obtenerVendedoresTarea()
    {
        try {
            $vendedores = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT id_Tarea, From tbl_tarea";
            $listaVendedores = sqlsrv_query($abrirConexion, $select);
            while ($fila = sqlsrv_fetch_array($listaVendedores, SQLSRV_FETCH_ASSOC)) {
                $vendedores[] = [
                    'idVendedor' => $fila['id_Usuario'],
                    'nombreVendedor' => $fila['nombre_Usuario']
                ];
            }
            return $vendedores;
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
            $select = "SELECT * FROM view_articulos";
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
            $estadoCliente = null;
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT CODCLIENTE FROM view_clientes WHERE CIF = '$rtn'";
            $consulta = sqlsrv_query($abrirConexion, $selectCliente);
            if($consulta->num_rows > 0){
                $arrCodCiente = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC);
                $codCliente = $arrCodCiente['CODCLIENTE'];
                $selectFacturas = "SELECT count(NUMFACTURA) AS CANT FROM view_facturasventa WHERE CODCLIENTE = '$codCliente'";
                $consulta= sqlsrv_query($abrirConexion, $selectFacturas);
                $cantFacturas = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC);
                $facturas = intval($cantFacturas['CANT']);
                if($facturas > 1){
                    $estadoCliente = true;
                }else{
                    $estadoCliente = false;
                } 
            }else{
                $estadoCliente = false;
            }
            return $estadoCliente;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerClientes(){
        try{
            $clientes = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT CODCLIENTE, NOMBRECLIENTE, CIF, TELEFONO1, DIRECCION1 FROM view_clientes";
            $listaClientes = sqlsrv_query($abrirConexion, $select);
            while($fila = sqlsrv_fetch_array($listaClientes, SQLSRV_FETCH_ASSOC)){
                $clientes[] = [
                    'codCliente' => $fila['CODCLIENTE'],
                    'nombre' => $fila['NOMBRECLIENTE'],
                    'rtn' =>$fila['CIF'],
                    'telefono' =>$fila['TELEFONO1'],
                    'direccion' =>$fila['DIRECCION1']
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
                $id= $idVendedor['idVendedor'];
                $insertUsuarioTarea = "INSERT INTO `tbl_vendedores_tarea` (`id_Tarea`, `id_usuario_vendedor`) 
                                    VALUES ('$idTarea', '$id');";
                 sqlsrv_query($abrirConexion, $insertUsuarioTarea);
            }
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerVendedores(){
        try{
            $vendedores = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT id_Usuario, usuario, nombre_Usuario FROM tbl_ms_usuario WHERE id_Rol = 4;";
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
            //Variables
            $rtn = ''; $estadoCliente = ''; $idClasificacionLead = '';
            $idOrigen = ''; $razon = ''; $rubro = ''; 
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            if($tipoTarea == '2'){
                $rtn = $datosTarea['rtn']; $estadoCliente = $datosTarea['tipoCliente']; $idClasificacionLead = $datosTarea['clasificacionLead'];
                $idOrigen = $datosTarea['origenLead']; $razon = $datosTarea['razon']; $rubro = $datosTarea['rubro']; 
                //Actualizamos los datos de la tarea
                $update = "UPDATE tbl_tarea SET `RTN_Cliente` = '$rtn', `estado_Cliente_Tarea` = '$estadoCliente', 
                `id_ClasificacionLead` = '$idClasificacionLead', `id_OrigenLead` = $idOrigen, `rubro_Comercial` = '$rubro', `razon_Social` ='$razon'
                WHERE `id_Tarea` = '$idTarea';";
                sqlsrv_query($abrirConexion, $update);
            }else{
                $rtn = $datosTarea['rtn']; $estadoCliente = $datosTarea['tipoCliente']; $razon = $datosTarea ['razon']; $rubro = $datosTarea['rubro']; 
                //Actualizamos los datos de la tarea
                $update = "UPDATE tbl_tarea SET `RTN_Cliente` = '$rtn', `estado_Cliente_Tarea` = '$estadoCliente', 
                `rubro_Comercial` = '$rubro', `razon_Social` ='$razon' WHERE `id_Tarea` = '$idTarea'";
                sqlsrv_query($abrirConexion, $update);
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
    public static function guardarProductosInteres($idTarea, $productos, $CreadoPor, $fechaCreacion){
        try{
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            foreach($productos as $producto){
                $idProducto = $producto['idProducto'];
                $cantProd = $producto['CantProducto'];
                $insert = "INSERT INTO `tbl_productointeres` (`id_Tarea`, `id_Articulo`, `cantidad`, `Creado_Por`, `Fecha_Creacion`) 
                VALUES ('$idTarea', '$idProducto', '$cantProd', '$CreadoPor', '$fechaCreacion');";
                sqlsrv_query($abrirConexion, $insert);
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
       sqlsrv_close($abrirConexion); //Cerrar conexion
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
    public static function agregarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $insertNuevoCliente = "INSERT INTO `tbl_CarteraCliente` (`nombre_Cliente`, `rtn_Cliente`, `telefono`, `correo`, `direccion`) 
            VALUES('$nombre', '$rtn', '$telefono', '$correo', '$direccion');";
            sqlsrv_query($abrirConexion, $insertNuevoCliente);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }
}