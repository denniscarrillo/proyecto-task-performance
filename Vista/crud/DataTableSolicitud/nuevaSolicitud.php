<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/DataTableSolicitud.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorDataTableSolicitud.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    require_once('enviarCorreoSolicitud.php');
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevaSolicitud = new DataTableSolicitud();
        $nuevaSolicitud->idFactura = $_POST['idFactura'];
        $nuevaSolicitud->rtnCliente = $_POST['RTNcliente'];
        $nuevaSolicitud->rtnClienteC = $_POST['RTNclienteC'];
        $nuevaSolicitud->descripcion = $_POST['descripcion'];
        $nuevaSolicitud->tipoServicio = $_POST['tipoServicio'];
        $nuevaSolicitud->correo = $_POST['correo'];
        $nuevaSolicitud->telefono = $_POST['telefono'];
        $nuevaSolicitud->ubicacion = $_POST['ubicacion'];
        $nuevaSolicitud->estadoAvance = 'PENDIENTE';
        $nuevaSolicitud->estadoSolicitud = 'ACTIVO';
        $nuevaSolicitud->creadoPor =  $user;
        $productos = json_decode($_POST['productos'], true);
        $nombrePDF =  $_POST['nombre'];
    
        $productosSolicitud = array();

        for($i=0; $i < count($productos); $i++){
            $productosSolicitud [] = [
                'idProducto'=> $productos[$i]['id'],
                'CantProducto'=> $productos[$i]['cant'],
            ];
           
        }        
    
        $data = ControladorDataTableSolicitud::NuevaSolicitud($nuevaSolicitud,$productosSolicitud);
        print json_encode($nuevaSolicitud, JSON_UNESCAPED_UNICODE);
        // Acceder a los valores devueltos
        $idSolicitud = $data['idSolicitud'];
        print json_encode($productosSolicitud, JSON_UNESCAPED_UNICODE);
        $CorreoT = 'tchenriquez15@gmail.com';
        enviarCorreoSolicitud($CorreoT, $nuevaSolicitud, $productosSolicitud, $idSolicitud, $nombrePDF);
        /* ========================= Evento Creacion nueva solicitud. ======================
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionSolicitud.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creó solicitud '.$_POST['tituloMensaje'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        =======================================================================================*/
    }
?>
