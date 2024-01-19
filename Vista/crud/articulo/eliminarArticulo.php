<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once("../../../Controlador/ControladorArticulo.php");

 
        $codArticulo= $_POST['CodArticulo'];
        $estadoEliminado = ControladorArticulo::eliminarArticulo($codArticulo);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
           
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    

    
?>