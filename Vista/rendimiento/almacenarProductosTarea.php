<?php
session_start(); //Reanudamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

if(isset($_SESSION['usuario']) && isset($_POST['productos'])){ //Validamos si existe una session y productos
    //Obtenemos el JSON y lo parseamos a ARRAY ASOCIATIVO
    $productos = json_decode($_POST['productos'], true);
    ControladorTarea::almacenarProductosInteres($_POST['idTarea'], $productos);
}
