<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once ("../../Modelo/Comision.php");
    require_once("../../Controlador/ControladorComision.php");
    require_once ("../../Modelo/Bitacora.php");
    require_once("../../Controlador/ControladorBitacora.php");
    

    $user = '';
    session_start();
    $eliminar = '';
    $estadoEliminado = '';
    if(isset($_SESSION['usuario'])) {
    $user = $_SESSION['usuario'];
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
/* ========================= Evento Eliminar Comisión. ======================*/
if ($estadoEliminado){
    $eliminar = "eliminó";
}else{
    $eliminar = "intentó eliminar";
}
$newBitacora = new Bitacora();
$accion = ControladorBitacora::accion_Evento();
date_default_timezone_set('America/Tegucigalpa');
$newBitacora->fecha = date("Y-m-d h:i:s");
$newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('V_COMISION.PHP');
$newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
$newBitacora->accion = $accion['Delete'];
$newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' eliminó la comisión #'.$idComision;
ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);

}
    }
