<?php
session_start(); //Reanudamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $estadoCliente = ControladorTarea::validarRtnCliente($_POST['rtnCliente']);
    if(!$estadoCliente){
        $datos = ControladorTarea::validarClienteExistenteCarteraCliente($_POST['rtnCliente']);
        (!$datos) ? print json_encode(['estado' => 'false'], JSON_UNESCAPED_UNICODE) : print json_encode($datos, JSON_UNESCAPED_UNICODE);
    } else {
        print json_encode(['estado' => 'true'], JSON_UNESCAPED_UNICODE);
    }
}