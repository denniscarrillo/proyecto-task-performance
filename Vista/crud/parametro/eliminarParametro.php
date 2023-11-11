<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Parametro.php");
    require_once("../../../Controlador/ControladorParametro.php");

    if(isset($_POST['parametro'])){
        $usuario = $_POST['usuario'];
        $estadoEliminado = ControladorParametro::eliminarParametro($parametro);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>
