<?php
    class ControladorConexionDB {
        private $dbConn;

        public function __construct(){
            require('db/ConexionDB.php');
            $objConn = new Conexion();
            $this->dbConn = $objConn->abrirConexionDB();
        }


        public function closeConexion(){
            mysqli_close($this->dbConn);
        }
    }
?>