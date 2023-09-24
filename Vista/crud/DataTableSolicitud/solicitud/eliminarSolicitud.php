<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Solicitud.php");
    require_once("../../../Controlador/ControladorUsuario.php");

    if(isset($_POST['solicitud'])){
        $usuario = $_POST['solicitud'];
        $estadoEliminado = ControladorUsuario::eliminarUsuario($usuario);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>