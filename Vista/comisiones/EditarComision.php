<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Comision.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorComision.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    $user = '';
    session_start();
    if(isset($_POST['idVenta']) || isset($_POST['idComision'])){
        $user = $_SESSION['usuario'];
        $nuevaComision = new Comision();
        $nuevaComision->idComision = intval($_POST['idComision']);
        $nuevaComision->idVenta = intval($_POST['idVenta']);
        $nuevaComision->idPorcentaje = intval($_POST['idPorcentaje']);
        $nuevaComision->comisionTotal = floatval($_POST['comisionTotal']);
        $nuevaComision->estadoComision = $_POST['estadoComision'];
        $nuevaComision->creadoPor = $user;
        $nuevaComision->fechaComision = $_POST['fechaComision'];
        $idTarea = ControladorComision::traerIdTarea(intval($_POST['idVenta']));
        $vendedores = ControladorComision::traerVendedores($idTarea);
        $estadoComision = ControladorComision::traerEstadoComision($_POST['estadoComision']);
        ControladorComision::actualizarComision($nuevaComision);

        ControladorComision::guardarComisionVendedor(($_POST['comisionTotal']), $idComision, $vendedores, $estadoComision, $user, $_POST['fechaComision']);
        $IdComision[] = [
        'idComision' => $idComision
        ]; 
        print json_encode($IdComision, JSON_UNESCAPED_UNICODE);
        /* ========================= Evento Editar Comision. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionComision.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó una comision '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }