<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Modelo/Comision.php');
require_once('../../Controlador/ControladorComision.php');

$user = '';
session_start();
if(isset($_POST['idVenta']) || isset($_POST['idComision'])){
    $user = $_SESSION['usuario'];
    $nuevaComision = new Comision();
    $nuevaComision->idVenta = intval($_POST['idVenta']);
    $nuevaComision->idPorcentaje = intval($_POST['idPorcentaje']);
    $nuevaComision->comisionTotal = floatval($_POST['comisionTotal']);
    $nuevaComision->estadoComision = 'Activa';
    $nuevaComision->creadoPor = $user;
    $nuevaComision->fechaComision = $_POST['fechaComision'];
    $idTarea = ControladorComision::traerIdTarea(intval($_POST['idVenta']));
    $vendedores = ControladorComision::traerVendedores($idTarea);
    
    $idComision = ControladorComision::registroComision($nuevaComision);
    ControladorComision::guardarComisionVendedor(floatval($_POST['comisionTotal']), $idComision, $vendedores, $estadoComision, $user, $_POST['fechaComision']);
    $IdComision[] = [
        'idComision' => $idComision
    ];
    print json_encode($IdComision, JSON_UNESCAPED_UNICODE);
}