<?php
    session_start(); //Reanudamos session
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorArticulo.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    if(isset($_SESSION['usuario']) && isset($_POST['codArticulo'])){
        $editarArticulo = new Articulo();
        $editarArticulo->codArticulo = $_POST['codArticulo'];
        $editarArticulo->Articulo = $_POST['articulo'];
        $editarArticulo->Detalle = $_POST['detalle'];
        $editarArticulo->Marca = $_POST['marca'];
        $editarArticulo->Precio = $_POST['precio'];
        $editarArticulo->Existencias = $_POST['existencias'];
        $editarArticulo->Modificado_Por = $_SESSION['usuario'];
        
        $estado = ControladorArticulo::editarArticulo($editarArticulo);
        print json_encode ($estado, JSON_UNESCAPED_UNICODE);
    }