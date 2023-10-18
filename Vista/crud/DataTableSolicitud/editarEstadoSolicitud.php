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
        $nuevaSolicitud = new DataTableSolicitud();
        $nuevaSolicitud->idSolicitud= $_POST['idSolicitud'];
        $nuevaSolicitud->EstadoSolicitud= $_POST['EstadoSolicitud'];
        $nuevaSolicitud->MotivoCancelacion= $_POST['MotivoCancelacion'];
        $nuevaSolicitud->modificadoPor= $user;
        ControladorDataTableSolicitud::actualizarEstadoSolicitud($nuevaSolicitud);
    }
   
?>