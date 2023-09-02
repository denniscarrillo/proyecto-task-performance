<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Rol.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRol.php");
    // $user = '';
    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
    //     $user = $_SESSION['usuario'];
        $nuevoRol = new Rol();
        $nuevoRol->rol = $_POST['rolUsuario'];
        $nuevoRol->descripcion = $_POST['descripcionRol'];
        date_default_timezone_set('America/Tegucigalpa');
        $nuevoRol->fechaCreacion = date("Y-m-d h:i:s");
        $nuevoRol->creadoPor = 'SUPERADMIN';
        ControladorRol::ingresarNuevoRol($nuevoRol);
        /* ========================= Evento Creacion nuevo Usuario. ======================*/
/*         $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creo usuario '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora); */
        /* =======================================================================================*/
    // }
?>