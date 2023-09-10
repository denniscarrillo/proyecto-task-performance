<?php
require_once ("../../../db/Conexion.php");
require_once ("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");

$data = array(
    'estado' => 'false'
);

if(ControladorUsuario::validarUsuarioExistente($_POST['usuario']))
{
    $data = array(
        'estado' => 'true'
    );
}


print json_encode($data, JSON_UNESCAPED_UNICODE);