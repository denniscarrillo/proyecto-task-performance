<?php

    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once ("../../Modelo/Rol.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("../../Controlador/ControladorRol.php");

$roles = ControladorRol::rolesUsuario();
$estadosUsuario = ControladorUsuario::obtenerEstadoUsuario();

?>

