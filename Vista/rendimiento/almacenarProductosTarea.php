<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
// header('location: ./almacenarProductosTarea.php');
session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $productos = json_decode($_POST['productos'], true, 4);
    $idTarea = $_POST['idTarea'];
    var_dump($productos);
    echo $productos;
    // ControladorTarea::guardarProductosInteres($idTarea, $productos);
}
