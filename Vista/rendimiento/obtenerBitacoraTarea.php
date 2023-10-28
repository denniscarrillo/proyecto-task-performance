<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start();
if(isset($_SESSION['usuario'])){
    $bitacoraTarea = ControladorTarea::consultarBitacoraTarea(intval($_POST['id_Tarea']));
    print json_encode($bitacoraTarea, JSON_UNESCAPED_UNICODE);
}