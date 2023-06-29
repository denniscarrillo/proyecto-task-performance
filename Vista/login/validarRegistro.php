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
        $nuevoUsuario->idEstado= 1;
        $nuevoUsuario->contrasenia = md5($_POST["contraseña"]);
        $nuevoUsuario->correo = $_POST["correoElectronico"]; 

        $cUsuario = new ControladorUsuario();
        $cUsuario->registroUsuario($nuevoUsuario);
        $mensaje = "Registro éxitoso";

        
    }
