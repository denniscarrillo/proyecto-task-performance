<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    //Datos auditoria
    $CreadoPor = $_SESSION['usuario'];
    date_default_timezone_set('America/Tegucigalpa');
    $fechaCreacion = date("Y-m-d");
    $idTarea = $_POST['idTarea']; //Id de la tarea
    //Obtenemos el JSON y lo parseamos a ARRAY ASOCIATIVO
    $productos = json_decode($_POST['productos'], true);
    $productosTarea = array();
    for($i=0; $i < count($productos); $i++){
        $productosTarea [] = [
            'idProducto'=> $productos[$i]['id'],
            'CantProducto'=> $productos[$i]['cant'],
        ];
    }
    ControladorTarea::almacenarProductosInteres($idTarea, $productosTarea);
}
