<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Parametro.php");
    require_once("../../../Controlador/ControladorParametro.php");

    
        $parametro = $_POST['usuario'];
        $data = ControladorParametro::eliminarParametro($parametro);
        print json_encode($data, JSON_UNESCAPED_UNICODE);
        
    
?>
