<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $tareas = ControladorTarea::obtenerTareasUsuario($idUsuario);
    print json_encode($tareas, JSON_UNESCAPED_UNICODE);
}