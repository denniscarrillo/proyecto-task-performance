<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
$llamadas = array();
$leads = array();
$cotizaciones = array();
$ventas = array();
session_start(); //Reaunamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $llamadas = ControladorTarea::obtenerTareasUsuario($idUsuario, 'Llamada');
    $leads = ControladorTarea::obtenerTareasUsuario($idUsuario, 'Lead');
    $cotizaciones = ControladorTarea::obtenerTareasUsuario($idUsuario, 'Cotizacion');
    $ventas = ControladorTarea::obtenerTareasUsuario($idUsuario, 'Venta');
}


