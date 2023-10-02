<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Solicitud.php");
require_once("../../../Controlador/ControladorSolicitud.php");

$data = array(
    'estado' => 'false'
);

if(ControladorSolicitud::servicioTecnicoExiste($_POST['servicioTecnico']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);