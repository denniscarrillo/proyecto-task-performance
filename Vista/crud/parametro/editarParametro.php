<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Parametro.php");
    require_once ("../../../Modelo/Pregunta.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorParametro.php");
    require_once("../../../Controlador/ControladorPregunta.php");
    require_once("../../../Controlador/ControladorBitacora.php");
  
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario']) && isset($_POST['idParametro'])){
        $nuevoParametro = new Parametro();
        $nuevoParametro->idParametro = $_POST['idParametro'];
        $nuevoParametro->parametro = $_POST['parametro'];
        $nuevoParametro->valor = $_POST['valor'];
        $nuevoParametro->descripcion = $_POST['descripcion'];
        $nuevoParametro->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $nuevoParametro->ModificadoPor = $_SESSION['usuario'];    
            if ($_POST['parametro'] == 'ADMIN PREGUNTAS'){
                $CantPreg = ControladorPregunta::obtenerCantPreguntas();
                if (intval($_POST['valor']) > $CantPreg){                                                         
                    $respuesta = [
                        'mensaje' => '*Se excede la cantidad de preguntas existentes',
                        'estado' => false             
                    ];
                    print json_encode ($respuesta,JSON_UNESCAPED_UNICODE);
                }
                else{
                    ControladorParametro::editarParametroSistema($nuevoParametro);
                    $respuesta = ['estado' => true];
                    print json_encode ($respuesta,JSON_UNESCAPED_UNICODE);
                }
            } else {
                ControladorParametro::editarParametroSistema($nuevoParametro);
                $respuesta = [ 'estado' => true];
                print json_encode ($respuesta,JSON_UNESCAPED_UNICODE);
            }      
            if ($_POST['parametro'] == 'ADMIN VIGENCIA') {
                $ArrayUsuarios = ControladorUsuario::obtenerIdUsuariosPassword();
                $vigenciaPassword = ControladorParametro::obtenerVigencia();
                ControladorUsuario::actualizarFechaVencimientoContrasena($ArrayUsuarios, $vigenciaPassword['Vigencia']);
            }      
        /* ========================= Evento Editar parámetro. ====================================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionParametro.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el parámetro '.$_POST['parametro'].' a '.$_POST['valor'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }