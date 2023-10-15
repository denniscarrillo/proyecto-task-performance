<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/DataTableSolicitud.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorDataTableSolicitud.php");

 
    if(isset($_POST['submit'])){
        $nuevaSolicitud = new idSolicitud();
        $nuevaSolicitud->usuario=$_SESSION['usuario'];
        $nuevaSolicitud->idSolicitud= $_POST['id_Solicitud'];
        $nuevaSolicitud->EstadoSolicitud= $_POST['EstadoSolicitud'];
        $nuevaSolicitud->MotivoCancelacion= $_POST['MotivoCancelacion'];
        $nuevaSolicitud->modificadoPor= $_SESSION['usuario'];
        ControladorDataTableSolicitud::actualizarEstadoSolicitud($nuevaSolicitud);
        //header("location:./gestionDataTableSolicitud.php");
    }
   
?>