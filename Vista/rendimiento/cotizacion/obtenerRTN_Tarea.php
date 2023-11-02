<?php
session_start(); //Reanudamos sesion
require_once('../../../db/Conexion.php');
require_once('../../../Modelo/Tarea.php');
require_once('../../../Controlador/ControladorTarea.php');

if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
   $existeRTN = ControladorTarea::obtenerRTN_Tarea(intval($_POST['idTarea']));
   echo $existeRTN;
}