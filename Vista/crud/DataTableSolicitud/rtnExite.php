<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/DataTableSolicitud.php");
require_once("../../../Controlador/ControladorDataTableSolicitud.php");

$data = array(
    'estado' => 'false'
);

if(ControladorUsuario::validarRtnExiste($_POST['rntcliente']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);