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
            $resultado = $abrirConexion->query("SELECT t.id_Tarea, t.id_EstadoAvance, t.titulo, t.fecha_Inicio, e.descripcion  FROM tbl_vendedores_tarea AS vt
            INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea
            INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
            WHERE vt.id_usuario_vendedor = '$idUser';");
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = $resultado->fetch_assoc()) {
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
        mysqli_close($abrirConexion); //Cerrar conexion
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
            $ejecutar_insert = mysqli_query($abrirConexion, $insert);
            $idTarea = mysqli_insert_id($abrirConexion);
            $insertUsuarioTarea = "INSERT INTO `tbl_vendedores_tarea` (`id_Tarea`, `id_usuario_vendedor`) 
                                    VALUES ('$idTarea', '$tarea->idUsuario');";
            $ejecutar_insert = mysqli_query($abrirConexion, $insertUsuarioTarea);
            /* $abrirConexion->query($insertUsuarioTarea); */
            
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerEstadoClienteTarea($rtnCliente)
    {
        try {
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT estado_Cliente_Tarea 
            FROM tbl_tarea WHERE id_EstadoAvance = 4 AND RTN_Cliente = '$rtnCliente'";
            $estadoCliente = $abrirConexion->query($select);
            while ($fila = $estadoCliente->fetch_assoc()) {
                $estado [] = [
                    'estadoClienteTarea' => $fila['estado_Cliente_Tarea']
                ];
            }
            return $estado;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function clienteExistente($rtnCliente)
    {
        try {
            $estado = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT COUNT(*) AS 'clienteExistente' FROM tbl_tarea WHERE RTN_Cliente = '$rtnCliente'";
            $estadoCliente = $abrirConexion->query($select);
            while ($fila = $estadoCliente->fetch_assoc()) {
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
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    /* public static function obtenerVendedoresTarea()
    {
        try {
            $vendedores = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT id_Tarea, From tbl_tarea";
            $listaVendedores = $abrirConexion->query($select);
            while ($fila = $listaVendedores->fetch_assoc()) {
                $vendedores[] = [
                    'idVendedor' => $fila['id_Usuario'],
                    'nombreVendedor' => $fila['nombre_Usuario']
                ];
            }
            return $vendedores;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerArticulos(){
        try{
            $articulos = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT * FROM view_articulos";
            $listaArticulos = $abrirConexion->query($select);
            while($fila = $listaArticulos->fetch_assoc()){
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
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerEstadosTarea(){
        try{
            $estadosTarea = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT * FROM tbl_estadoavance";
            $listaEstados = $abrirConexion->query($select);
            while($fila = $listaEstados->fetch_assoc()){
                $estadosTarea[] = [
                   'idEstado' => $fila['id_EstadoAvance'],
                   'estado' => $fila['descripcion'] 
                ];
            }
            return $estadosTarea;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function validarTipoCliente($rtn){
        try{
            $existeRtn = false;
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT CIF FROM view_clientes WHERE CIF = '$rtn'";
            $selectTarea = "SELECT id_EstadoAvance, RTN_Cliente FROM tbl_Tarea WHERE id_EstadoAvance = 4 AND RTN_Cliente = '$rtn'";
            $rtnCliente = $abrirConexion->query($selectCliente);
            $rtnTarea = $abrirConexion->query($selectTarea);
            if($rtnCliente->num_rows > 0 || $rtnTarea->num_rows > 0){
                $existeRtn = true;
            }
            return $existeRtn;
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerClientes(){
        try{
            $clientes = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT CODCLIENTE, NOMBRECLIENTE, CIF, TELEFONO1, DIRECCION1 FROM view_clientes";
            $listaClientes = $abrirConexion->query($select);
            while($fila = $listaClientes->fetch_assoc()){
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
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function agregarVendedoresTarea($idTarea, $idVendedores){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            foreach($idVendedores as $idVendedor){
                $id= $idVendedor['idUsuario'];
                $insertUsuarioTarea = "INSERT INTO `tbl_vendedores_tarea` (`id_Tarea`, `id_usuario_vendedor`) 
                                    VALUES ('$idTarea', '$id');";
                $ejecutar_insert = mysqli_query($abrirConexion, $insertUsuarioTarea);
            }
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
    }
    public static function obtenerVendedores(){
        try{
            $vendedores = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $select = "SELECT id_Usuario, usuario, nombre_Usuario FROM tbl_ms_usuario WHERE id_Rol = 4;";
            $listaVendedores = $abrirConexion->query($select);
            while($fila = $listaVendedores->fetch_assoc()){
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
        mysqli_close($abrirConexion); //Cerrar conexion
    }
}