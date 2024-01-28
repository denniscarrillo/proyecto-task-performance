<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once("../../../Controlador/ControladorMetricas.php");


        $metrica= $_POST['id_Metrica'];
        $estadoEliminado = ControladorMetricas::eliminarMetrica($metrica);
        print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);

    
?>