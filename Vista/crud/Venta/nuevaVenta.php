<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Venta.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorVenta.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevaVenta = new Venta();
        $nuevaVenta->rtnCliente = $_POST['rtn'];
        $nuevaVenta->totalVenta = $_POST['venta'];
        $nuevaVenta->creadoPor = $user;
        ControladorVenta::crearNuevaVenta($nuevaVenta);
         /* ========================= Evento Creacion Venta. ==================================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       date_default_timezone_set('America/Tegucigalpa');
       $newBitacora->fecha = date("Y-m-d h:i:s"); 
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionVenta.php');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
       $newBitacora->accion = $accion['Insert'];
       $newBitacora->descripcion = 'El usuario '.$user.' creó una nueva venta para el RTN'.$_POST['rtn'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }
?>