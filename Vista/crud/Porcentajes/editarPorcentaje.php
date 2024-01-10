<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Porcentajes.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorPorcentajes.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoPorcentaje = new Porcentajes();
        $nuevoPorcentaje->idPorcentaje = $_POST['idPorcentaje'];
        $nuevoPorcentaje->estadoPorcentaje = $_POST['estadoPorcentaje'];
        $nuevoPorcentaje->ModificadoPor = $user;
        // date_default_timezone_set('America/Tegucigalpa');
        // $nuevoPorcentaje->fechaModificacion = date("Y-m-d");
        ControladorPorcentajes::editarPorcentaje($nuevoPorcentaje);
        // Porcentajes::editarPorcentaje($nuevoPorcentaje);
        /* ========================= Evento editar porcentaje. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPorcentajes.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el porcentaje '.'"'.$_POST['descripcionPorcentaje'].'"'.' a '.$_POST['valorPorcentaje'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }