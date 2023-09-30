<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Rol.php");
require_once("../../../Controlador/ControladorRol.php");

$data = array(
    'estado' => 'false'
);

if(ControladorRol::rolExiste($_POST['rol']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);