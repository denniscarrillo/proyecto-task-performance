<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorArticulo.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevoArticulo = new Articulo();
        $nuevoArticulo->Articulo = $_POST['Articulo'];
        $nuevoArticulo->Detalle = $_POST['Detalle'];
        $nuevoArticulo->Marca = $_POST['Marca'];
        $nuevoArticulo->Precio = $_POST['Precio'];
        $nuevoArticulo->Existencias = $_POST['Existencias'];
        $nuevoArticulo->Creado_Por = $_SESSION['usuario'];
        ControladorArticulo::registroNuevoArticulo($nuevoArticulo);
    }