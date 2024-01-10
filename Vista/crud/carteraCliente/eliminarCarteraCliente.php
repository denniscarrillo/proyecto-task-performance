<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevoCliente = new CarteraClientes();
        $nuevoCliente->idcarteraCliente = $_POST['id'];
        $nuevoCliente->nombre = $_POST['carteraCliente'];
        $nuevoCliente->rtn = $_POST['rtn'];
        $nuevoCliente->telefono = $_POST['telefono'];
        $nuevoCliente->correo= $_POST['correo'];
        $nuevoCliente->direccion = $_POST['direccion'];
        $nuevoCliente->estadoContacto = $_POST['estado'];
        date_default_timezone_set('America/Tegucigalpa');
        $nuevoCliente->modificadoPor = $_SESSION['usuario'];
        ControladorCarteraClientes::editarCliente($nuevoCliente);
       // print json_encode($data = ['estado'=>'false']);
        /* ========================= Evento Editar cartera cliente. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionCarteraClientes.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó al cliente '.$_POST['nombre'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
?>