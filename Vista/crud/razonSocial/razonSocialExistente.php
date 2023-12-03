<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/RazonSocial.php");
require_once("../../../Controlador/ControladorRazonSocial.php");

$data = array(
    'estado' => 'false'
);

if(ControladorRazonSocial::RazonSocialExiste($_POST['razonSocial']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);