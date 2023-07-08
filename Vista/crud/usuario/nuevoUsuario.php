<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once('enviarCorreoNuevoUsuario.php');

    $nuevoUsuario = new Usuario();
    $nuevoUsuario->nombre = $_POST['nombre'];
    $nuevoUsuario->usuario = $_POST['usuario'];
    $nuevoUsuario->contrasenia = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);
    $nuevoUsuario->correo = $_POST['correo'];
    $nuevoUsuario->idRol = $_POST['rol'];
    $nuevoUsuario->idEstado = 1;

    ControladorUsuario::registroUsuario($nuevoUsuario);
    enviarCorreoNuevoUsuario($nuevoUsuario->correo, $nuevoUsuario->usuario, $_POST['contrasenia']);
?>
