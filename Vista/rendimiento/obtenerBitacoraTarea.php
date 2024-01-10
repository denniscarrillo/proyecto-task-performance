<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');

session_start();
if(isset($_SESSION['usuario'])){
    $bitacoraTarea = ControladorBitacoraTarea::consultarBitacoraTarea(intval($_POST['id_Tarea']));
    print json_encode($bitacoraTarea, JSON_UNESCAPED_UNICODE);
}