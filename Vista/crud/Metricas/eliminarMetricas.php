<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once("../../../Controlador/ControladorMetricas.php");

   
        $metrica = $_POST['id_Metrica'];
     //   $estadoEliminado = ControladorMetricas::eliminarMetrica($metrica);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
           
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    
?>