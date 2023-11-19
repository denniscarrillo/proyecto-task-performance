<?php 
    session_start(); //Reanudamos session
    require_once("../../../db/Conexion.php");
    require_once("../../../Modelo/Tarea.php");
    require_once("../../../Controlador/ControladorTarea.php");

    if(isset($_SESSION['usuario'])){
        $estado = ControladorTarea::anularCotizacion(intval($_POST['idCotizacion']), $_SESSION['usuario']);
        print json_encode($estado, JSON_UNESCAPED_UNICODE);
    }