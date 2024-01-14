<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once("../../../Controlador/ControladorArticulo.php");

    if(isset($_POST['usuario'])){
        $Articulo= $_POST['Articulo'];
        $estadoEliminado = ControladorArticulo::eliminarArticulo($Articulo);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
           
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>