<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once ("../../Modelo/Comision.php");
    require_once("../../Controlador/ControladorComision.php");

    $estadoEliminado = null;
    if(isset($_POST['idComision'])){
        $idComision = $_POST['idComision'];
        $estadoEliminado = ControladorComision::eliminandoComision($idComision);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'anulada'
            ];
            ControladorComision::SimularAnularComision($idComision);
            ControladorComision::SimularAnularComisionVendedor($idComision);
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>

        <!-- /* ========================= Evento Editar Comision. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s");
        $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionComision.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Delete'];
        $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' eliminó una comision ';
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    }
    // $data = [
    //     'user' => 'Respuesta'
    // ];
    // print json_encode($data, JSON_UNESCAPED_UNICODE); -->
