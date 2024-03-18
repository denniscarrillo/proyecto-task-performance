<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorDataTableObjeto.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $editarObjeto = new DataTableObjeto();
        $editarObjeto->id_Objeto = $_POST['id_Objeto'];
        $editarObjeto->objeto = $_POST['objeto']; 
        $editarObjeto->descripcion= $_POST['descripcion'];
        $editarObjeto->modificadoPor = $user;
        ControladorDataTableObjeto::editarObjeto($editarObjeto);
       /* ========================= Evento Editar Objeto. ====================================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       date_default_timezone_set('America/Tegucigalpa');
       $newBitacora->fecha = date("Y-m-d h:i:s"); 
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONOBJETO.PHP');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
       $newBitacora->accion = $accion['Update'];
       $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó la descripción del objeto '.$_POST['objeto'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }
