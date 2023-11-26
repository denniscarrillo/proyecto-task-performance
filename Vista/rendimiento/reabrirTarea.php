<?php
require_once('../../db/Conexion.php');
// require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/Tarea.php');
// require_once('../../Modelo/BitacoraTarea.php');
// require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Controlador/ControladorTarea.php');
// require_once('../../Controlador/ControladorBitacoraTarea.php');

session_start();
if(isset($_SESSION['usuario'])){
    $estadoReabierto = ControladorTarea::reabrirTarea(intval($_POST['idTarea']));
    print json_encode($estadoReabierto, JSON_UNESCAPED_UNICODE);
}