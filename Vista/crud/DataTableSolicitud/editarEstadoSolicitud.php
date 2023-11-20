<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableSolicitud.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorDataTableSolicitud.php");

    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $cancelarSolicitud = new DataTableSolicitud();
        $cancelarSolicitud->idSolicitud= $_POST['idSolicitud'];
        $cancelarSolicitud->EstadoAvance= $_POST['EstadoAvance'];
        $cancelarSolicitud->EstadoSolicitud= $_POST['EstadoSolicitud'];       
        $cancelarSolicitud->MotivoCancelacion= $_POST['MotivoCancelacion'];
        $cancelarSolicitud->modificadoPor= $user;
        ControladorDataTableSolicitud::actualizarEstadoSolicitud($cancelarSolicitud);
    }
   
?>