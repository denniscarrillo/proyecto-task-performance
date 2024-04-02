<?php
    session_start(); //Reanudamos session
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
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
        ControladorArticulo::editarArticulo($editarArticulo);
        /* ========================= Evento Editar articulo. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONARTICULO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó el artículo #'.$_POST['codArticulo'].' '.$_POST['articulo'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }