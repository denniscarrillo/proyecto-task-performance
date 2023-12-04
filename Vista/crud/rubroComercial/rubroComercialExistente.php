<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/RubroComercial.php");
require_once("../../../Controlador/ControladorRubroComercial.php");

$data = array(
    'estado' => 'false'
);

if(ControladorRubroComercial::RubroComercialExiste($_POST['rubroComercial']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);