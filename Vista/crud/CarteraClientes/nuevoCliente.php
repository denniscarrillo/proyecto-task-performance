<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    //require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");
    //require_once("../../../Controlador/ControladorBitacora.php");
    //require_once('enviarCorreoNuevoUsuario.php');
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['cliente'])){
        $user = $_SESSION['cliente'];
        $nuevoCliente = new CarteraClientes();
        $nuevoCliente->idCarteraCliente = $_POST['idCarteraCliente'];
        $nuevoCliente->nombre = $_POST['nombre'];
        $nuevoCliente->rtn = $_POST['rtn'];
        $nuevoCliente->telefono = $_POST['telefono'];
        $nuevoUsuario->correo = $_POST['correo'];
        $nuevoUsuario->estadoContacto = $_POST['estadoContacto'];
        ControladorCarteraClientes::registroNuevoCliente($nuevoCliente);
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
    }
?>
