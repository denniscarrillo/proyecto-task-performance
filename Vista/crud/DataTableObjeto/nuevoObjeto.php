<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorDataTableObjeto.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoObjeto = new DataTableObjeto();
        $nuevoObjeto->objeto = $_POST['objeto'];
        $nuevoObjeto->descripcion= $_POST['descripcion'];
        $nuevoObjeto->creadoPor = $user;
        $nuevoObjeto->modificadoPor = $user;
        ControladorDataTableObjeto::CrearObjeto($nuevoObjeto);
        print json_encode($nuevoObjeto, JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Creacion Objeto. ==================================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       date_default_timezone_set('America/Tegucigalpa');
       $newBitacora->fecha = date("Y-m-d h:i:s"); 
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONOBJETO.PHP');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
       $newBitacora->accion = $accion['Insert'];
       $newBitacora->descripcion = 'El usuario '.$user.' creó el objeto '.$_POST['objeto'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }

