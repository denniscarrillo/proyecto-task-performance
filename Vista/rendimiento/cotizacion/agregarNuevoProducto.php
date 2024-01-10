<?php 
    session_start();
    require_once("../../../db/Conexion.php");
    require_once("../../../Modelo/Tarea.php");
    require_once("../../../Controlador/ControladorTarea.php");

    if(isset($_SESSION['usuario']) && isset($_POST['nuevoProducto'])){
        $idProducto = ControladorTarea::almacenarProducto($_POST['nuevoProducto']);
        ControladorTarea::insertarPrecioProducto($idProducto, $_POST['nuevoProducto']['precio']);
    }

