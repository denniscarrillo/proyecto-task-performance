<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $articulos = ControladorTarea::obtenerArticulosTarea();
    print json_encode($articulos, JSON_UNESCAPED_UNICODE);
}