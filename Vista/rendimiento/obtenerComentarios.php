<?php
session_start();
require_once('../../db/Conexion.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');

if(isset($_SESSION['usuario']) && isset($_POST['id_Tarea'])){
    $comentariosTarea = ControladorBitacoraTarea::mostrarComentariosTarea(intval($_POST['id_Tarea']));
    print json_encode($comentariosTarea, JSON_UNESCAPED_UNICODE);
}