<?php
session_start(); //Reanudamos sesion
// require_once('../../db/Conexion.php');
// require_once('../../Modelo/Tarea.php');
// require_once('../../Controlador/ControladorTarea.php');

// if(isset($_SESSION['usuario']) && $_POST['idTarea']){ //Validamos si existe una session y el usuario
//   $estados = ControladorTarea::obtenerHistorialEstadosTarea(intval($_POST['idTarea']));
//   print json_encode($estados, JSON_UNESCAPED_UNICODE);
// }