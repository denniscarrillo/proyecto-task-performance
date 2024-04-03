<?php
    session_start(); //Reanudamos sesion
    require_once('../../../db/Conexion.php');
    require_once('../../../Modelo/Articulo.php');
    require_once('../../../Controlador/ControladorArticulo.php');

    if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
        $productos = ControladorArticulo::obtenerTodosArticulos();
        print json_encode($productos, JSON_UNESCAPED_UNICODE);
    }