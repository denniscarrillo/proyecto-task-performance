<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Tarea.php");
require_once("../../Controlador/ControladorTarea.php");

if(isset($_POST['rtnCliente'])){
    $estadoCliente = ControladorTarea::obtenerestadoClienteTarea($_POST['rtnCliente']);
    print json_encode($estadoCliente, JSON_UNESCAPED_UNICODE);
}