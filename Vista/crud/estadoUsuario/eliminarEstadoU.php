<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/EstadoUsuario.php");
    require_once("../../../Controlador/ControladorEstadoUsuario.php");

   
    $estadoEliminado = ControladorEstadoUsuario::eliminarEstadoU($_POST['idEstadoU']);
    print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
    
?>