<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once ("../../Modelo/Parametro.php");
    require_once("../../Controlador/ControladorParametro.php");
    // $user = '';
    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
    //     $user = $_SESSION['usuario'];
    // }
    // if(isset($_POST['nuevoUsuario'])){ 
    //     $data = array();
    //     $usuario = $_POST['nuevoUsuario'];
        // $userExiste = ControladorUsuario::registro($usuario);
        // if($userExiste>0){
        //     $data [] = [
        //         'usuario'=> $userExiste
        //     ];
        //     print json_encode($data, JSON_UNESCAPED_UNICODE);
        // }else{
        //     $data [] = [
        //         'usuario'=> 0
        //     ];
        //     print json_encode($data, JSON_UNESCAPED_UNICODE);
        // }
    // }
    if(isset($_POST["submit"])){
        $nuevoUsuario = new Usuario();        
        $nuevoUsuario->usuario = $_POST["usuario"];
        $nuevoUsuario->nombre = $_POST["nombre"];
        $nuevoUsuario->idEstado= 1; 
        $nuevoUsuario->contrasenia = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
        $nuevoUsuario->correo = $_POST["correoElectronico"]; 
        $nuevoUsuario->intentosFallidos = 0;
        $nuevoUsuario->idRol = 1;
        $nuevoUsuario->preguntasContestadas = 0;
        date_default_timezone_set('America/Tegucigalpa');
        $nuevoUsuario->fechaCreacion = date("Y-m-d h:i:s"); 
        $nuevoUsuario->creadoPor = $_POST["usuario"];

        $fechaInicial = date("Y-m-d");
        $Vigencia = ControladorParametro::obtenerVigencia();
        $valor = $Vigencia['Vigencia'];
        $fecha_nueva = date('Y-m-d', strtotime($fechaInicial . '+' . intval($Vigencia['Vigencia']) . ' days'));

        $nuevoUsuario->fechaV = $fecha_nueva;
        ControladorUsuario::registroUsuario($nuevoUsuario);
        header('location: login.php');
        // $mensaje = "Registro éxitoso";
    }
    
