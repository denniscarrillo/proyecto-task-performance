<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   require_once ("../../../Modelo/Tarea.php");
   require_once("../../../Controlador/ControladorTarea.php");
   
   session_start(); //Reanudamos sesion
    if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
        $cotizaciones = ControladorTarea::obtenerCotizacionesUsuario($_SESSION['usuario']);
        print json_encode($cotizaciones, JSON_UNESCAPED_UNICODE);
    }