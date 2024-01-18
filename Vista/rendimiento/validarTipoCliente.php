<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $estadoClienteC = ControladorTarea::validarClienteExistenteCarteraCliente($_POST['rtnCliente']);
    if(isset($estadoClienteC['nombre'])){
        $existe = ['estado' => 'true' ];  
        print json_encode($existe, JSON_UNESCAPED_UNICODE);
    } 
}