<?php
session_start(); //Reanudamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Modelo/Bitacora.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorBitacora.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');
require_once('../../Controlador/ControladorUsuario.php');

$estadosTarea = array();
$clasificacionLeads = array();
$origenLeads = array();
$datosTareaDB = array();

if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    //Actualizar los campos con la nueva información
    if(isset($_POST['tipoCliente'])){
        $tipo_Tarea = $_POST['idEstado'];
        $tarea = array();
        $id_Tarea = $_POST['idTarea'];
        $Creado_Por = $_SESSION['usuario'];
        $Modificador_Por = $_SESSION['usuario'];
        $evidencia = $_POST['nFactura'];
        $rtn = '';
        $nombre = '';
        $estadoTarea = ControladorBitacoraTarea::obtenerEstadoTarea($tipo_Tarea);
        if($_POST['tipoCliente'] == 'Nuevo'){
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];  
            $tarea = [
                'titulo' => $_POST['titulo'],
                'tipoCliente' => $_POST['tipoCliente'],
                'rubro' => $_POST['rubrocomercial'],
                'razon' => $_POST['razonsocial'],
                'ModificadoPor' => $Modificador_Por
            ];
            if($_POST['idEstado'] == '2'){
                $tarea += [
                    'clasificacionLead' => $_POST['clasificacionLead'],
                    'origenLead' => $_POST['origenLead'],
                ];
            }
            if(!ControladorTarea::validarEstadoClienteTarea(intval($_POST['idTarea']))){
                $tarea += [
                    'rtn' => $_POST['rtnCliente']
                ];
            }
            if(count($tarea) > 0){
                ControladorTarea::actualizarTarea($id_Tarea, $tipo_Tarea, $tarea);
                editarTareaBitacora($id_Tarea, $estadoTarea, $_SESSION['usuario']);
                //Valiar que no exista esa misma evidencia en la tabla evidencia
                $estadoE = ControladorTarea::validarSiExisteEvidencia($evidencia);
                if(isset($_POST['nFactura']) && intval($_POST['idEstado'] ) == 4 && $estadoE['estado'] == false){
                    // $idTarea, $evidencia, $accion, $creadoPor
                    ControladorTarea::guardarFacturaTarea($id_Tarea, $evidencia, intval($_POST['accion']), $Creado_Por);
                    if(intval($_POST['accion']) == 0){
                        guardarFacturaTareaBitacora($id_Tarea, $evidencia, $estadoTarea, $_SESSION['usuario']);
                    }else{
                        editoFacturaTareaBitacora($id_Tarea, $evidencia, $estadoTarea, $_SESSION['usuario']);
                    }
                }
                // !isset($datosTareaDB['RTN_Cliente']) && (isset($_POST['nombre']) && isset($_POST['rtnCliente']))
                if(isset($_POST['nombre']) && isset($_POST['rtnCliente'])){
                    var_dump($_POST['rtnCliente']);
                    $nombre = $_POST['nombre'];
                    $rtn = $_POST['rtnCliente'];
                    ControladorTarea::insertarNuevoCliente($nombre, $rtn, $telefono, $correo, $direccion, $Creado_Por);
                } else {
                    $updateTarea = new Tarea();
                    $updateTarea->rtnCliente = $_POST['rtn'];
                    $updateTarea->telefono = $_POST['telefono'];
                    $updateTarea->correo = $_POST['correo'];
                    $updateTarea->direccion = $_POST['direccion'];
                    $updateTarea->Modificado_Por = $Modificador_Por;
                    ControladorTarea::editarNuevoClienteTarea($updateTarea);
                }
            }
        } else {
            $tarea = [
                'titulo' => $_POST['titulo'],
                'tipoCliente' => $_POST['tipoCliente'],
                'rubro' => $_POST['rubrocomercial'],
                'razon' => $_POST['razonsocial'],
                'ModificadoPor' => $Modificador_Por
            ];
            //Se valida el estado del cliente de la tarea cliente es existente
            if(!ControladorTarea::validarEstadoClienteTarea(intval($_POST['idTarea']))){
                $tarea += [
                    'rtn' => $_POST['rtnCliente'],
                    'codCliente' => $_POST['codCliente']
                ];
            }
            if($_POST['idEstado'] == '2'){
                $tarea += [
                    'clasificacionLead' => $_POST['clasificacionLead'],
                    'origenLead' => $_POST['origenLead']
                ];
            } 
            if(count($tarea) > 0){
                ControladorTarea::actualizarTarea($id_Tarea, $tipo_Tarea, $tarea);
                editarTareaBitacora($id_Tarea, $estadoTarea, $_SESSION['usuario']);
                if(isset($_POST['nFactura'])  && intval($_POST['idEstado'] ) == 4  && $estadoE['estado'] == false){
                    ControladorTarea::guardarFacturaTarea($id_Tarea, $evidencia, intval($_POST['accion']), $Creado_Por);
                    if(intval($_POST['accion']) == 0){
                        guardarFacturaTareaBitacora($id_Tarea, $evidencia, $estadoTarea, $_SESSION['usuario']);
                    }else{
                        editoFacturaTareaBitacora($id_Tarea, $evidencia, $estadoTarea, $_SESSION['usuario']);
                    }
                }
            }
        }
    }
    if(isset($_POST['idTarea'])){
        //Obtenener todos los datos de la tarea a editar(cuando ya existen)
        if(ControladorTarea::validarEstadoClienteTarea(intval($_POST['idTarea']))){
            $estadoTarea = (intval($_POST['idEstado']) == 2) ? 2: 0;
            $datosTarea = ControladorTarea::obtenerDatosTarea($estadoTarea, intval($_POST['idTarea']));
            $datosTarea += [
                'productos' => ControladorTarea::obtenerProductosInteres($_POST['idTarea'])
            ];
            print json_encode($datosTarea, JSON_UNESCAPED_UNICODE);
        } else {
            $datosTarea = [
                'data' => false
            ];
            print json_encode($datosTarea, JSON_UNESCAPED_UNICODE);
        }
    }
}
function editarTareaBitacora($idTarea, $estado, $usuario){
    /* ====================== Evento, el usuario ha modificado una nueva tarea. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($usuario));
    $newBitacora = new BitacoraTarea();
    $newBitacora->idTarea = intval($idTarea);
    $newBitacora->descripcionEvento = 'Ha editado la tarea # '.$idTarea.' en el estado '.$estado;
    $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
}
function guardarFacturaTareaBitacora($idTarea, $factura, $estado, $usuario){
    /* ====================== Evento, el usuario ha modificado una nueva tarea. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($usuario));
    $newBitacora = new BitacoraTarea();
    $newBitacora->idTarea = intval($idTarea);
    $newBitacora->descripcionEvento = 'Ha agregado la evidencia factura #'.$factura.' en la tarea # '.$idTarea.' en el estado '.$estado;
    $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
}
function editoFacturaTareaBitacora($idTarea, $factura, $estado, $usuario){
    /* ====================== Evento, el usuario ha modificado una nueva tarea. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($usuario));
    $newBitacora = new BitacoraTarea();
    $newBitacora->idTarea = intval($idTarea);
    $newBitacora->descripcionEvento = 'Ha editado la evidencia factura #'.$factura.' en la tarea # '.$idTarea.' en el estado '.$estado;
    $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
}