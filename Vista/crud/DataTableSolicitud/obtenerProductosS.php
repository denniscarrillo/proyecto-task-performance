<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/DataTableSolicitud.php");
    require_once("../../../Controlador/ControladorDataTableSolicitud.php");

    if(isset($_GET['IdSolicitud'])){
        $productos = ControladorDataTableSolicitud::obtenerProductosS($_GET['IdSolicitud']);
        print json_encode($productos, JSON_UNESCAPED_UNICODE);
    }
?>