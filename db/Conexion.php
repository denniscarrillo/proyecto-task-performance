
<?php
 class Conexion {
     private $ServerName = "DESKTOP-REQKDIP\SQLEXPRESS";
     private $ConexionInfo = array("Database"=>"COCINAS_Y_EQUIPOS", "CharacterSet"=>"UTF-8");
     
     #Abrir conexión al servidor de MySQL
    public function abrirConexionDB(){
        try{
            $conn = sqlsrv_connect($this->ServerName, $this->ConexionInfo);
            if($conn == false){
                die(print_r(sqlsrv_errors(), true));
            }
            return $conn;
        }
        catch(Exception $e){
            echo "Ocurrió un error al conectar a la base de datos: ". $e->getMessage();
        }
    }}
    ?>