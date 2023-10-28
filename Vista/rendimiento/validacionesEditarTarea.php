<?php
session_start(); //Reanudamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Modelo/Bitacora.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorBitacora.php');

$estadosTarea = array();
$clasificacionLeads = array();
$origenLeads = array();
$datosTareaDB = array();

if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    //Obtenener todos los datos de la tarea a editar(cuando ya existen)
    $estadosTarea = ControladorTarea::traerEstadosTarea();
    $clasificacionLeads = ControladorTarea::obtenerClasificacionLead();
    $origenLeads = ControladorTarea::obtenerOrigenLead();
    if(ControladorTarea::validarEstadoClienteTarea(intval($_GET['idTarea']))){
        $tipoTarea = 0;
        if($_GET['estadoTarea'] == '2') {
            //Cuando la tarea sea de tipo LEAD
            $tipoTarea = 2;
        } else {
            $tipoTarea = 0;
        }
        $datosTareaDB = ControladorTarea::obtenerDatosTarea($tipoTarea, intval($_GET['idTarea']));
    }
    //Actualizar los campos con la nueva información
    if(isset($_POST["actualizarTarea"])){
        // $id_Tarea = null;
        $tipo_Tarea = $_POST['estadoTarea'];
        $cliente = array();
        $tarea = array();
        $id_Tarea = $_POST['idTarea'];
        $Creado_Por = $_SESSION['usuario'];
        if($_POST['radioOption'] == 'Nuevo'){
            $rtn = $_POST['rtnCliente'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];  
            $Modificador_Por = $_SESSION['usuario'];
            $tarea = [
                'tipoCliente' => $_POST['radioOption'],
                'rtn' => $_POST['rtnCliente'],
                'rubro' => $_POST['rubrocomercial'],
                'razon' => $_POST['razonsocial'],
                'ModificadoPor' => $Modificador_Por
            ];
            if($_POST['estadoTarea'] == '2'){
                $tarea += [
                    'clasificacionLead' => $_POST['clasificacionLead'],
                    'origenLead' => $_POST['origenLead'],
                    'ModificadoPor' => $Modificador_Por
                ];
            }
            if(count($tarea) > 0 || count($cliente) > 0){
                ControladorTarea::actualizarTarea($id_Tarea, $tipo_Tarea, $tarea);
                ControladorTarea::insertarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion, $Creado_Por);
                header('location: ./v_tarea.php');
            }
        }else {
            $tarea = [
                'tipoCliente' => $_POST['radioOption'],
                'rtn' => $_POST['rtnCliente'],
                'rubro' => $_POST['rubrocomercial'],
                'razon' => $_POST['razonsocial']
            ];
            if($_POST['estadoTarea'] == '2'){
                $tarea += [
                    'clasificacionLead' => $_POST['clasificacionLead'],
                    'origenLead' => $_POST['origenLead']
                ];
            }
            if(count($tarea) > 0 || count($cliente) > 0){
                ControladorTarea::actualizarTarea($id_Tarea, $tipo_Tarea, $tarea);
                header('location: ./v_tarea.php');
            }
        }
    }
}