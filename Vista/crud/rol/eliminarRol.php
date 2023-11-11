<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Rol.php");
    require_once("../../../Controlador/ControladorRol.php");

    if(isset($_POST['rol'])){
        $usuario = $_POST['usuario'];
        $estadoEliminado = ControladorUsuario::eliminarRol($Rol);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
           
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>