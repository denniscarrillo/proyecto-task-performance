<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = "";

    if(isset($_POST["submit"])){
        $nuevoUsuario = new Usuario();
        // $nuevoUsuario->idUsuario = 1;
        $nuevoUsuario->usuario = $_POST["usuario"];
        $nuevoUsuario->nombre = $_POST["nombre"];
        $nuevoUsuario->estado = "Nuevo";
        $nuevoUsuario->contrasenia = $_POST["contraseña"];
        $nuevoUsuario->correo = $_POST["correoElectronico"];

        $cUsuario = new ControladorUsuario();
        $cUsuario->registro($nuevoUsuario);
        $mensaje = "Registro éxitoso";

        
    }
