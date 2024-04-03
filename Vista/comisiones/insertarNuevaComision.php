<?php
require_once("../../db/Conexion.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/Comision.php");
require_once("../../Modelo/Parametro.php");
require_once("../../Modelo/Bitacora.php");
require_once("../../Controlador/ControladorUsuario.php");
require_once("../../Controlador/ControladorComision.php");
require_once("../../Controlador/ControladorParametro.php");
require_once("../../Controlador/ControladorBitacora.php");

$user = null;
session_start();
if(isset($_POST['idVenta']) || isset($_POST['idComision']) || isset($_POST['$ComisionTotal'])){
    $user = $_SESSION['usuario'];
    $nuevaComision = new Comision();
    /* $nuevaComision->idComision = intval($_POST['id_Comision']); */
    $nuevaComision->idVenta = intval($_POST['idVenta']);
    $nuevaComision->idPorcentaje = intval($_POST['idPorcentaje']);
    $nuevaComision->comisionTotal = floatval($_POST['comisionTotal']);
    $nuevaComision->estadoComision = 'Activa';
    $nuevaComision->estadoLiquidacion = 'Pendiente';
    // $nuevaComision->estadoCobro = 'Pendiente Cobro';
    // $nuevaComision->metodoPago = 'Pendiente';
    $nuevaComision->creadoPor = $user;
    // date_default_timezone_set('America/Tegucigalpa');
    // $nuevaComision->fechaComision = date("Y-m-d", strtotime($_POST['fechaComision']));
    $idTarea = ControladorComision::traerIdTarea(intval($_POST['idVenta']));
    $vendedores = ControladorComision::traerVendedores($idTarea);
    $idComision = ControladorComision::registroComision($nuevaComision);
    var_dump($idComision);
    echo''.$idTarea.''.$idComision.
    ControladorComision::guardarComisionVendedor(floatval($_POST['comisionTotal']), $idComision, $vendedores, $user);
    // header('Location: v_comision.php');
    /* ========================= Evento Creacion Comisión. =============================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('V_NUEVACOMISION.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
    $newBitacora->accion = $accion['Insert'];
    $newBitacora->descripcion = 'El usuario '.$user.' creó la comisión #'.$_POST['idComision'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}