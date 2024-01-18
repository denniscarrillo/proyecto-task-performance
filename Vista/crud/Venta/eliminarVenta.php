<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Venta.php");
    require_once("../../../Controlador/ControladorVenta.php");

   
        $numFactura = $_POST['numFactura'];
        $estadoEliminado = ControladorVenta::eliminarVenta($numFactura);
        $data = array();
        if($estadoEliminado == true) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
           
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    
?>