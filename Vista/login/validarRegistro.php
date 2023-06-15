<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = "";

    if(isset($_POST["submit"])){
        $nuevoUsuario = new Usuario();
        // $nuevoUsuario->idUsuario = 1;
        $nuevoUsuario->rtn = $_POST["rtnUsuario"];
        $nuevoUsuario->usuario = $_POST["usuario"];
        $nuevoUsuario->nombre = $_POST["nombre"];
        $nuevoUsuario->estado = "Nuevo";
        $nuevoUsuario->contrasenia = $_POST["contraseña"];
        $nuevoUsuario->correo = $_POST["correoElectronico"];
        $nuevoUsuario->telefono = $_POST["telefono"];
        $nuevoUsuario->direccion = $_POST["direccion"];

        $cUsuario = new ControladorUsuario();
        $cUsuario->registro($nuevoUsuario);
        $mensaje = "Registro éxitoso";
    }
