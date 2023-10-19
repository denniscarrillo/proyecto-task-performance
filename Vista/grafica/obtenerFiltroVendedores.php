<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');

    $traerVendedores = ControladorUsuario::traerVendedores();
    print json_encode($traerVendedores, JSON_UNESCAPED_UNICODE);
