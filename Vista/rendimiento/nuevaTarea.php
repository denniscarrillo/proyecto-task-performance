<?php
if(isset($_POST['submit'])){
    session_start();
    $tarea = new Tarea(); //Creamos un objeto a partir de la clase TAREA
    //Llenamos algunas propiedades del objeto para nueva Tarea
    date_default_timezone_set('America/Tegucigalpa');
    $tarea->idEstadoAvance = $_POST['tipoTarea'];
    $tarea->titulo = $_POST['titulo'];
    $tarea->idUsuario =  ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $tarea->fechaInicio = date("Y-m-d");
    $tarea->Creado_Por = $_SESSION['usuario'];
    $tarea->Fecha_Creacion = date("Y-m-d");
    ControladorTarea::insertarNuevaTarea($tarea);
}