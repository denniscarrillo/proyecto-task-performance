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
        $user = $_SESSION['usuario'];
        $editarArticulo = new Articulo();
        $editarArticulo->codArticulo = $_POST['CodArticulo'];
        $editarArticulo->Articulo = $_POST['Articulo'];
        $editarArticulo->Detalle = $_POST['Detalle'];
        $editarArticulo->Marca = $_POST['Marca'];
        $editarArticulo->Modificado_Por = $user;
        ControladorArticulo::editarArticulo($editarArticulo);
    }
?>