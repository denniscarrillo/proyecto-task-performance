<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/DataTableSolicitud.php");   
    require_once("../../../Controlador/ControladorDataTableSolicitud.php");
 
        $nuevoProductoS = new DataTableSolicitud();
        $nuevoProductoS->idSolicitud = $_POST[''];
        $nuevoProductoS->CodArticulo = $_POST[''];
        $nuevoProductoS->Cant = $_POST[''];
        
        ControladorDataTableSolicitud::NuevoProductoSolic($nuevoProductoS);
        print json_encode($nuevoProductoS, JSON_UNESCAPED_UNICODE);
?>
