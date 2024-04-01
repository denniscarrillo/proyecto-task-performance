<?php
    session_start(); //Reanudamos session
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once("../../../Controlador/ControladorArticulo.php");

    if(isset($_POST['codArticulo']) && isset($_POST['nuevoPrecio']) && isset($_SESSION['usuario'])){
       $estadoNuevoPrecio = ControladorArticulo::nuevoPrecioArticulo
        (
            $_POST['codArticulo'], 
            $_POST['nuevoPrecio'], 
            $_SESSION['usuario']
        );
        print json_encode($estadoNuevoPrecio, JSON_UNESCAPED_UNICODE);
    } 