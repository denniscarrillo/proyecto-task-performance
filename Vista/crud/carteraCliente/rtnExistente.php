<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/CarteraClientes.php");
require_once("../../../Controlador/ControladorCarteraClientes.php");

$data = array(
    'estado' => 'false'
);

if(ControladorCarteraClientes::rtnExiste($_POST['rtn']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);