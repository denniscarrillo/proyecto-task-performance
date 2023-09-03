
<?php
 class Conexion {
    private $ServerName = 'DELL-E6430\SQLEXPRESS';
    private $ConexionInfo = array("Database"=>"COCINAS_Y_EQUIPOS", "CharacterSet"=>"UTF-8");
    
    #Abrir conexión al servidor de MySQL
    public function abrirConexionDB(){
        $conn = mysqli_connect($this->hostName, $this->userName, $this->password, $this->dbName);
        return $conn;
    }
 }
?>