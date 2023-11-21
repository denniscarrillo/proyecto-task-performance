<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/DataTableSolicitud.php");
require_once("../../../Controlador/ControladorDataTableSolicitud.php");

$data = array(
    'estado' => 'false',
    'mensaje' => ''
);

$validacion = ControladorDataTableSolicitud::validarRtnExiste($_POST['rtnCliente']);

if ($validacion['existe']) {
    $data['estado'] = 'true';
    $data['mensaje'] = $validacion['mensaje'];
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
