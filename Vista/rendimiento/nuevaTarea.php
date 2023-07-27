<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

if(isset($_POST['tipoTarea'])){
    session_start();
    $user = $_SESSION['usuario'];
    $tarea = new Tarea(); //Creamos un objeto a partir de la clase TAREA
    //Llenamos algunas propiedades del objeto para nueva Tarea
    date_default_timezone_set('America/Tegucigalpa');
    if($_POST['tipoTarea'] == 'llamada'){
        $tarea->idEstadoAvance = 1;
    } else if($_POST['tipoTarea'] == 'lead'){
        $tarea->idEstadoAvance = 2;
    } else if ($_POST['tipoTarea'] == 'cotizacion'){
        $tarea->idEstadoAvance = 3;
    } else{
        $tarea->idEstadoAvance = 4;
    }
    $tarea->titulo = $_POST['titulo'];
    $tarea->idUsuario =  ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $tarea->fechaInicio = date("Y-m-d");
    $tarea->Creado_Por = $user;
    $tarea->Fecha_Creacion = date("Y-m-d");
    ControladorTarea::insertarNuevaTarea($tarea);
    unset($_POST['tipoTarea']); //Vaciar variable
}