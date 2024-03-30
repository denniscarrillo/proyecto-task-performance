<?php
require_once __DIR__. '../../vendor/autoload.php';
use Dotenv\Dotenv;
// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable( __DIR__.'../../');
$dotenv->load();

class Conexion {
    private $serverName;
    private $dbName;
    private $conexionInfo;
    private $characterSet;

    // Constructor de la clase
    public function __construct() {
        // Configurar las propiedades de la clase con las variables de entorno
        $this->serverName = $_ENV['DB_HOST'];
        $this->characterSet = $_ENV['CHARACTER_SET'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->conexionInfo = array("Database" => $this->dbName, "CharacterSet" => $this->characterSet);
    }

    // Método para abrir la conexión a la base de datos
    public function abrirConexionDB(){
        try{
            $conn = sqlsrv_connect($this->serverName, $this->conexionInfo);
            if($conn == false){
                die(print_r(sqlsrv_errors(), true));
            }
            return $conn;
        }
        catch(Exception $e){
            echo "Ocurrió un error al conectar a la base de datos: ". $e->getMessage();
        }
    }
}