<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Rol.php");
    require_once("../../../Controlador/ControladorRol.php");

    if(isset($_POST['id_Rol'])){
        $rol = $_POST['id_Rol'];
        $estadoEliminado = ControladorRol::eliminarRol($rol);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>