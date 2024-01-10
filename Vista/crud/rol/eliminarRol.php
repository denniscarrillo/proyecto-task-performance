<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Rol.php");
    require_once("../../../Controlador/ControladorRol.php");

   
        $rol = $_POST['id_Rol'];
        $estadoEliminado = ControladorRol::eliminarRol($rol);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
           
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    
?>