<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");

    if(isset($_POST['CarteraCliente'])){
        $CarteraCliente = $_POST['CarteraCliente'];
        $estadoEliminado = ControladorCarteraCliente::eliminarCarteraCliente($CarteraCliente);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>