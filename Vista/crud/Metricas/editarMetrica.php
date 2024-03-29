<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorMetricas.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $nuevaMetrica = new Metricas();
        $nuevaMetrica->idMetrica = $_POST['idMetrica'];
        $nuevaMetrica->meta = $_POST['meta'];
        $nuevaMetrica->modificadoPor = $_SESSION['usuario'];
        ControladorMetricas::editarMetricas($nuevaMetrica);
        /* ========================= Evento Editar Usuario. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionMetricas.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $metrica = ControladorMetricas::obtenerNombreMetrica($_POST['idMetrica']);
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' actualizó la métrica #'.$_POST['idMetrica'].' '.$metrica.' la meta a '.$_POST['meta'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }