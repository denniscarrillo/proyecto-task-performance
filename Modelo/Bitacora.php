<?php
    class Bitacora {
        public $idBitacora;
        public $fecha;
        public $idUsuario;
        public $accion;
        public $idObjeto;
        public $descripcion;
        //Método de captura los eventos y los almacena en la tabla bitacora.
        public static function EVENT_BITACORA($datosEvento){
            //Recibir objeto y obtener parametros
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $ejecutarSQL = "INSERT INTO tbl_ms_bitacora (fecha, id_Usuario, id_Objeto, accion, descripcion) 
            VALUES('$datosEvento->fecha','$datosEvento->idUsuario','$datosEvento->idObjeto','$datosEvento->accion','$datosEvento->descripcion')";
            $ejecutarSQL = sqlsrv_query($consulta, $ejecutarSQL);
            sqlsrv_close($consulta); #Cerramos la conexión.
            
        }
        //Método que recibe un objeto y devuelve su id.
        public static function obtener_Id_Objeto($objeto){
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $query = "SELECT id_Objeto FROM tbl_ms_objetos WHERE objeto = '$objeto'";
            $resultado = sqlsrv_query($consulta, $query);
            $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            $idObjeto = $fila['id_Objeto'];
            sqlsrv_close($consulta); #Cerramos la conexión.
            return $idObjeto;
        }
        public static function acciones_Evento(){
            $acciones = [
                'Insert' => 'Creacion',
                'Update' => 'Actualizacion',
                'Delete' => 'Eliminacion',
                'Login'  => 'Iniciar Sesion',
                'Logout'  => 'Cerrar Session',
                'income'  => 'Ingreso',
                'Exit' => 'Salio'
            ];
            return $acciones;
        }

        public static function obtenerBitacorasUsuario(){
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $query= "SELECT B.id_Bitacora, B.fecha, u.usuario, o.objeto, B.accion, B.descripcion FROM tbl_ms_bitacora AS B
            INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = B.id_Usuario
            INNER JOIN tbl_ms_objetos AS o ON o.id_Objeto = B.id_Objeto;";
            $obtenerBitacoras = sqlsrv_query($consulta, $query);
            while($fila = sqlsrv_fetch_array($obtenerBitacoras, SQLSRV_FETCH_ASSOC)){
                $bitacoras [] = [
                    'id_Bitacora' => $fila["id_Bitacora"],
                    'fecha' => $fila["fecha"],
                    'Usuario' => $fila["usuario"],
                    'Objeto' => $fila["objeto"],
                    'accion' => $fila["accion"],
                    'descripcion' => $fila["descripcion"],
                ];
            }
            sqlsrv_close($consulta); #Cerramos la conexión.
            return $bitacoras;
        } 
    }