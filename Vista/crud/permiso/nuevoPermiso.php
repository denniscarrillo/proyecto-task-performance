<?php
    require_once ("../../../db/Conexion.php");
    // require_once ("../../../Modelo/Usuario.php");
    // require_once ("../../../Modelo/Bitacora.php");
    // require_once("../../../Controlador/ControladorUsuario.php");
    // require_once("../../../Controlador/ControladorBitacora.php");
    require_once ("../../../Modelo/Parametro.php");
    require_once("../../../Controlador/ControladorParametro.php");
    // $user = '';
    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
    //     $user = $_SESSION['usuario'];
        $nuevoPermiso = new Permiso();
        $nuevoPermiso->idRol = $_POST['rol'];
        $nuevoPermiso->idObjeto = $_POST['objeto'];
        $nuevoPermiso->permisoConsultar = $_POST['consultar'];
        $nuevoPermiso->PermisoInsercion = $_POST['insertar'];
        $nuevoPermiso->PermisoActualizacion = $_POST['actualizar'];
        $nuevoPermiso->PermisoEliminacion = $_POST['eliminar'];
        ControladorPermiso::registroUsuario($nuevoPermiso);
        /* ========================= Evento Creacion nuevo Usuario. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creo usuario '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    // }
?>