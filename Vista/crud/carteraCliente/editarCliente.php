<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $editarCliente = new CarteraClientes();
        $editarCliente->rtn = $_POST['rtn'];
        $editarCliente->telefono = $_POST['telefono'];
        $editarCliente->correo= $_POST['correo'];
        $editarCliente->direccion = $_POST['direccion'];
        $editarCliente->estadoContacto = $_POST['estadoContacto'];
        $editarCliente->modificadoPor = $_SESSION['usuario'];
        ControladorCarteraClientes::editarCliente($editarCliente);
        print json_encode($data = ['estado'=>'false']);
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