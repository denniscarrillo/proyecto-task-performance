<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reaunamos sesion
if(!isset($_SESSION['usuario'])){ //Validamos si no existe una session redirijimos al login
    header('location: ../login/login.php');
} else {
    require 'nuevaTarea.php';
}


