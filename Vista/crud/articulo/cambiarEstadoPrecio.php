<?php
    session_start(); //Reanudamos session
    require_once ("../../../db/Conexion.php");
    // require_once ("../../../Modelo/Usuario.php");
    // require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Articulo.php");
    // require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorArticulo.php");
    // require_once("../../../Controlador/ControladorBitacora.php");

    if(isset($_SESSION['usuario']) && isset($_POST['idPrecio'])){
        $nuevoEstado = ($_POST['estadoActual'] == 'ACTIVO') ? 'INACTIVO' : 'ACTIVO';
        $estadoActualizacion = ControladorArticulo::actualizarEstadoPrecio
        (
            $_POST['idPrecio'], 
            $_POST['codArticulo'], 
            $nuevoEstado,  
            $_SESSION['usuario']
        );
        print json_encode($estadoActualizacion, JSON_UNESCAPED_UNICODE);
    }