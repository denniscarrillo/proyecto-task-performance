<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Articulo.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorArticulo.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevoArticulo = new Articulo();
        $nuevoArticulo->Articulo = $_POST['Articulo'];
        $nuevoArticulo->Detalle = $_POST['Detalle'];
        $nuevoArticulo->Marca = $_POST['Marca'];
        $nuevoArticulo->Precio = $_POST['Precio'];
        $nuevoArticulo->Existencias = $_POST['Existencias'];
        $nuevoArticulo->Creado_Por = $_SESSION['usuario'];
        $nuevoArticulo->Modificado_Por = $_SESSION['usuario'];
        ControladorArticulo::registroNuevoArticulo($nuevoArticulo);
        /* ========================= Evento Creacion articulo. ==================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONARTICULO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creó el articulo '.$_POST['Articulo'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }