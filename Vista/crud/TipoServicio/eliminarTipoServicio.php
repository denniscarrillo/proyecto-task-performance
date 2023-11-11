<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/TipoServicio.php");
    require_once("../../../Controlador/ControladorTipoServicio.php");

    if(isset($_POST['TipoServicio'])){
        $TipoServicio = $_POST['TipoServicio'];
        $estadoEliminado = ControladorTipoServicio::eliminarTipoServicio($TipoServicio);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>
