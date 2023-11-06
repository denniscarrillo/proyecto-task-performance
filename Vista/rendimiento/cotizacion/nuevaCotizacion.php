<?php 
    session_start(); //Reanudamos session
    require_once("../../../db/Conexion.php");
    require_once("../../../Modelo/Tarea.php");
    require_once("../../../Controlador/ControladorTarea.php");

    if(isset($_SESSION['usuario']) && isset($_POST['datosCotizacion'])){
        $idCotizacion = ControladorTarea::nuevaCotizacion($_POST['datosCotizacion'], $_SESSION['usuario']);
        ControladorTarea::productosCotizacion($idCotizacion['id_Cotizacion'], $_POST['productos'], $_SESSION['usuario']);
    }
