<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");

$CantVendedores = ControladorUsuario::obtenerCantVendedores();
print json_encode($CantVendedores, JSON_UNESCAPED_UNICODE);
    