<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = "";

    if(isset($_POST["submit"])){
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->usuario = $_POST["usuario"];
        $nuevoUsuario->nombre = $_POST["nombre"];
        $nuevoUsuario->idEstado= 1; 
        $nuevoUsuario->contrasenia = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
        $nuevoUsuario->correo = $_POST["correoElectronico"]; 
        $nuevoUsuario->idRol = 1; 
        
        ControladorUsuario::registroUsuario($nuevoUsuario);
        $mensaje = "Registro éxitoso";
    }
