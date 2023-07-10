<?php
require('../../db/Conexion.php');
$mensaje = "";
if (isset($_POST['submit'])){
    $conexion = new Conexion();

    $token =$_POST['token'];
    $res = $conexion->abrirConexionDB()->query("SELECT token FROM tbl_token WHERE token='$token'");
    
    if ($res->num_rows > 0) {
       header('location: restablecer.php');
    } else {
        $mensaje= "Token no válido o incorrecto";
    }
}

?>