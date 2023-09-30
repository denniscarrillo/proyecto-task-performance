<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Porcentajes.php");
require_once("../../../Controlador/ControladorPorcentajes.php");

$data = array(
    'estado' => 'false'
);

if(ControladorPorcentajes::porcentajeExiste($_POST['valorPorcentaje']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);