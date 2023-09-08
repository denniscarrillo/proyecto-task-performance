<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Pregunta.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorPregunta.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $insertarPregunta = new Pregunta();
        $insertarPregunta->pregunta = ($_POST['pregunta']);
        $insertarPregunta->CreadoPor = $user;
        ControladorPregunta::agregarPregunta($insertarPregunta);
        /* ========================= Evento Creacion pregunta. ==================================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       date_default_timezone_set('America/Tegucigalpa');
       $newBitacora->fecha = date("Y-m-d h:i:s"); 
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPregunta.php');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
       $newBitacora->accion = $accion['Insert'];
       $newBitacora->descripcion = 'El usuario '.$user.' creó la pregunta a '.$_POST['pregunta'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }

?>



