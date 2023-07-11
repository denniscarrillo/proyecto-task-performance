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
            $ejecutarSQL = "INSERT INTO tbl_ms_bitacora (`fecha`, `id_Usuario`, `id_Objeto`, `accion`, `descripcion`) 
            VALUES('$datosEvento->fecha','$datosEvento->idUsuario','$datosEvento->idObjeto','$datosEvento->accion','$datosEvento->descripcion')";
            $consulta->query($ejecutarSQL);
            mysqli_close($consulta); #Cerramos la conexión.
        }
        //Método que recibe un objeto y devuelve su id.
        public static function obtener_Id_Objeto($objeto){
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $resultado = $consulta->query("SELECT id_Objeto FROM tbl_ms_objetos WHERE objeto = '$objeto'");
            $fila = $resultado->fetch_assoc();
            $idObjeto = $fila['id_Objeto'];
            mysqli_close($consulta); #Cerramos la conexión.
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
    }