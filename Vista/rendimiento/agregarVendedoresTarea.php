<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $idTarea = $_POST['idTarea'];
    $vendedores = json_decode($_POST['vendedores'], true);
    //Guardamos los vendedores agregados a la tarea
    ControladorTarea::agregarVendores($idTarea, $vendedores);
}