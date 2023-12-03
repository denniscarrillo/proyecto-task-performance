<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/EstadoUsuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorEstadoUsuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $estado = ControladorEstadoUsuario::InsertarNuevoEstado($_POST['estado'], $user);
    }