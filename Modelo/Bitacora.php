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
            VALUES(GETDATE(),'$datosEvento->idUsuario','$datosEvento->idObjeto','$datosEvento->accion','$datosEvento->descripcion')";
            $ejecutarSQL = sqlsrv_query($consulta, $ejecutarSQL);
            sqlsrv_close($consulta); #Cerramos la conexión.
        }
        //Método que recibe un objeto y devuelve su id.
        public static function obtener_Id_Objeto($objeto){
            $idObjeto = null;
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $query = "SELECT id_Objeto FROM tbl_ms_objetos WHERE objeto = '$objeto'";
            $resultado = sqlsrv_query($consulta, $query);
            $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
            if(isset( $fila['id_Objeto'])){
                $idObjeto = $fila['id_Objeto'];
            }
            sqlsrv_close($consulta); #Cerramos la conexión.
            return $idObjeto;
        }
        public static function acciones_Evento(){
            $acciones = [
                'Insert' => 'Crear',
                'Update' => 'Actualizar',
                'Delete' => 'Eliminar',
                'Report' => 'Generar reporte',
                'tryDelete' => 'Intentar eliminar',
                'Login'  => 'Iniciar Sesión',
                'BloqueoPreguntas' => 'Recup. contraseña',
                'Logout'  => 'Cerrar sesión',
                'income'  => 'Ingresar',
                'fallido' => 'Ingresar sin permiso',
                'Exit' => 'Salir',
                'filterQuery' => 'Consultar por filtro',
                'backup' => 'Generar backup',
                'restorer' => 'Restaurar backup',
                'debugger' => 'Depurar bitácora'
            ];
            return $acciones;
        }
        public static function obtenerBitacorasUsuario($fechaDesde, $fechaHasta){
            $bitacoras = array();
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $query= "SELECT ROW_NUMBER() OVER(ORDER BY B.id_Bitacora ASC) AS Num, B.id_Bitacora, B.fecha, u.usuario, o.objeto, B.accion, B.descripcion FROM tbl_ms_bitacora AS B
                INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = B.id_Usuario
                INNER JOIN tbl_ms_objetos AS o ON o.id_Objeto = B.id_Objeto
                WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta';";
            $obtenerBitacoras = sqlsrv_query($consulta, $query);
            if(sqlsrv_errors() === null) { //Validamos is ocurre algun error a nivel de DB entonces lo manejamos y evitamos hacer el fetch
                while($fila = sqlsrv_fetch_array($obtenerBitacoras, SQLSRV_FETCH_ASSOC)){
                    $bitacoras [] = [
                        'item' => $fila["Num"],
                        'id_Bitacora' => $fila["id_Bitacora"],
                        'fecha' => $fila["fecha"],
                        'Usuario' => $fila["usuario"],
                        'Objeto' => $fila["objeto"],
                        'accion' => $fila["accion"],
                        'descripcion' => $fila["descripcion"],
                    ];
                }
                sqlsrv_close($consulta); #Cerramos la conexión.
            }
            return $bitacoras;     
        }
        public static function depurarBitacora($fechaDesde, $fechaHasta){
            try {
                $conn = new Conexion();
                $conexion = $conn->abrirConexionDB();
                $query = "DELETE FROM tbl_MS_Bitacora WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta';";
                sqlsrv_query($conexion, $query);
                sqlsrv_close($conexion);
                return true;
            } catch (Exception $error) {
                return false;
            }
        }

        public static function obtenerBitacoraPdf($buscar){
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $query= "SELECT B.id_Bitacora, B.fecha, u.usuario, o.objeto, B.accion, B.descripcion FROM tbl_ms_bitacora AS B
            INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = B.id_Usuario
            INNER JOIN tbl_ms_objetos AS o ON o.id_Objeto = B.id_Objeto
            WHERE CONCAT(B.id_Bitacora, B.fecha, u.usuario, o.objeto, B.accion, B.descripcion) 
            LIKE '%' + '$buscar' + '%';";
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