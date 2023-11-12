<?php
session_start(); //Reanudamos sesion
require_once('../../../db/Conexion.php');
// require_once('../../../Modelo/Bitacora.php');
// require_once('../../../Controlador/ControladorBitacora.php');
require_once('../../../Modelo/Tarea.php');
require_once('../../../Controlador/ControladorTarea.php');

if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $datosCotizacion = ControladorTarea::obtenerDatosCotizacion(intval($_POST['idTarea']));
    (!empty($datosCotizacion)) ? print json_encode($datosCotizacion, JSON_UNESCAPED_UNICODE) : print json_encode($res = [false], JSON_UNESCAPED_UNICODE);
 }