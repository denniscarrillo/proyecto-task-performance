<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Modelo/Articulo.php");
require_once("../../../Controlador/ControladorArticulo.php");

$codArticulo = $_POST['codArticulo'];
$estadoEliminado = ControladorArticulo::eliminarArticulo($codArticulo);
print json_encode($estadoEliminado, JSON_UNESCAPED_UNICODE);
