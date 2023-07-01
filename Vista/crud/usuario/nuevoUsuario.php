<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");

    $nuevoUsuario = new Usuario();
    $nuevoUsuario->nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
    $nuevoUsuario->usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
    $nuevoUsuario->$contrasenia = (isset($_POST['contrasenia'])) ? $_POST['contrasenia'] : '';
    $nuevoUsuario->$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
    $nuevoUsuario->$idRol = (isset($_POST['idRol'])) ? $_POST['idRol'] : '';
    $nuevoUsuario->$idEstado = (isset($_POST['idEstado'])) ? $_POST['idEstado'] : '';

    ControladorUsuario::registroUsuario($nuevoUsuario);

?>
