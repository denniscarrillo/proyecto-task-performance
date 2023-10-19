<?php
session_start();
require_once("../../db/Conexion.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");

if(isset($_SESSION['usuario']) && isset($_POST['userPassword'])) {
    $currentPassword = ControladorUsuario::login($_SESSION['usuario'], $_POST['userPassword']);
    echo json_encode($currentPassword, JSON_UNESCAPED_UNICODE);
}