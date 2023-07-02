<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");

    $usuario = $_POST['usuario'];
    ControladorUsuario::eliminarUsuario($usuario);
?>