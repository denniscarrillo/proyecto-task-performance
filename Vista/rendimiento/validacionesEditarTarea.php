<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
$estadosTarea = array();
$clasificacionLeads = array();
$origenLeads = array();
session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $estadosTarea = ControladorTarea::traerEstadosTarea();
    $clasificacionLeads = ControladorTarea::obtenerClasificacionLead();
    $origenLeads = ControladorTarea::obtenerOrigenLead();
    //Obtener datos y guardar cambios en tarea.
    if(isset($_POST['actualizarTarea'])){
        $id_Tarea = $_GET['idTarea'];
        echo 'Id Tarea: '.$id_Tarea;
        $tipo_Tarea = $_POST['estadoTarea'];
        $cliente = array();
        $tarea = array();
        if($_POST['radioOption'] == 'Nuevo'){

            $rtn = $_POST['rtn'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
   
            // $cliente[] = [
            //     'rtn'=> $_POST['rtn'],
            //     'nombre' => $_POST['nombre'],
            //     'telefono' => $_POST['telefono'],
            //     'correo' => $_POST['correo'],
            //     'direccion' => $_POST['direccion']
            // ];
            $tarea[] = [
                'tipoCliente' => $_POST['radioOption'],
                'rtn'=> $_POST['rtn'],
                'rubro' => $_POST['rubrocomercial'],
                'razon' => $_POST['razonsocial'] 
            ];
            if($_POST['estadoTarea'] == '2'){
                $tarea += [
                    'clasificacionLead' => $_POST['clasificacionlead'],
                    'origenLead' => $_POST['origenlead']
                ];
            }
            if(count($tarea) > 0 || count($cliente) > 0){
                ControladorTarea::actualizarTarea($id_Tarea, $tipo_Tarea, $tarea);
                ControladorTarea::insertarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion);
            }
        }else {
            $tarea[] = [
                'tipoCliente' => $_POST['radioOption'],
                'rtn'=> $_POST['rtn'],
                'rubro' => $_POST['rubrocomercial'],
                'razon' => $_POST['razonsocial']
            ];
            if($_POST['estadoTarea'] == '2'){
                $tarea += [
                    'clasificacionLead' => $_POST['clasificacionlead'],
                    'origenLead' => $_POST['origenlead']
                ];
            }
            if(count($tarea) > 0 || count($cliente) > 0){
                ControladorTarea::actualizarTarea($id_Tarea, $tipo_Tarea, $tarea);
            }
        }
    }
}