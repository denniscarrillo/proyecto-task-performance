<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorDataTableObjeto.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoObjeto = new DataTableObjeto();
        $nuevoObjeto->objeto = $_POST['objeto'];
        $nuevoObjeto->descripcion= $_POST['descripcion'];
        $nuevoObjeto->CreadoPor = $user;
        DataTableObjeto::CrearObjeto($nuevoObjeto);
        print json_encode($nuevoObjeto, JSON_UNESCAPED_UNICODE);
    }
?>
