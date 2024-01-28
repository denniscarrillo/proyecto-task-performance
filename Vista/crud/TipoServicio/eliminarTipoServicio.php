<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/TipoServicio.php");
    require_once("../../../Controlador/ControladorTipoServicio.php");

    $estadoEliminado = ControladorTipoServicio::eliminarTipoServicio($_POST['idTipoServico']);
    print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);
?>
