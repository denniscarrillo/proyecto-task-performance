<?php
session_start();
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

if(isset($_SESSION['usuario']) && isset($_POST['id_Tarea'])){
    $comentariosTarea = ControladorTarea::mostrarComentariosTarea(intval($_POST['id_Tarea']));
    print json_encode($comentariosTarea, JSON_UNESCAPED_UNICODE);
}