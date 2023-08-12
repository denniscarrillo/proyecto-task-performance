<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once("../../../Controlador/ControladorMetricas.php");

    if(isset($_POST['id_Metrica'])){
        $idMetrica = $_POST['id_Metrica'];
        $estadoEliminado = ControladorMetricas::eliminarMetrica($idMetrica);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>