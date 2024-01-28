<?php
require_once('../../../db/Conexion.php');
require_once('../../../Modelo/Pregunta.php');
require_once('../../../Controlador/ControladorPregunta.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $existe = array();
    $estadoPregunta = ControladorPregunta::validarPreguntaExistente($_POST['pregunta']);
    print json_encode($estadoPregunta, JSON_UNESCAPED_UNICODE);
}