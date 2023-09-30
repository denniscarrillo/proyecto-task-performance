<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Pregunta.php");
require_once("../../../Controlador/ControladorPregunta.php");

$data = array(
    'estado' => 'false'
);

if(ControladorPregunta::preguntaExiste($_POST['pregunta']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);