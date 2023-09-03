<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Porcentajes.php");
    //require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorPorcentajes.php");
    //require_once("../../../Controlador/ControladorBitacora.php");
    //require_once('enviarCorreoNuevoUsuario.php');
    // $user = '';
    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
    //     $user = $_SESSION['usuario'];
        $nuevoPorcentaje = new Porcentajes();
        $nuevoPorcentaje->valorPorcentaje = $_POST['valorPorcentaje'];
        $nuevoPorcentaje->descripcionPorcentaje= $_POST['descripcionPorcentaje'];
        $nuevoPorcentaje->estadoPorcentaje = $_POST['estadoPorcentaje'];
        $nuevoPorcentaje->CreadoPor = 'SUPERADMIN';
        Porcentajes::registroNuevoPorcentaje($nuevoPorcentaje);
        //enviarCorreoNuevoUsuario($nuevoUsuario->correo, $nuevoUsuario->usuario, $_POST['contrasenia']);
        /* ========================= Evento Creacion nuevo Usuario. ======================*/
        //$newBitacora = new Bitacora();
        //$accion = ControladorBitacora::accion_Evento();
        //date_default_timezone_set('America/Tegucigalpa');
        //$newBitacora->fecha = date("Y-m-d h:i:s"); 
        //$newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        //$newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        //$newBitacora->accion = $accion['Insert'];
        //$newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creo usuario '.$_POST['usuario'];
        //ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    // }
?>
