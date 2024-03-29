<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");

    if(isset($_POST['usuario'])){
        $usuario = $_POST['usuario'];
        $estadoEliminado = ControladorUsuario::eliminarUsuario($usuario);
        ControladorUsuario::inactivarUsuario($usuario);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        /* ========================= Evento Eliminar tipo servicio. ===============================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONUSUARIO.PHP');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        if($estadoEliminado){
            $eliminar = " eliminó ";
            $newBitacora->accion = $accion['Delete'];
        }else{
            $eliminar = " intentó eliminar ";
            $newBitacora->accion = $accion['tryDelete'];
        }
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.'el usuario #'.$_POST['idUsuario'].' '.$_POST['usuario'].' en su lugar se cambio su estado a inactivo';
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }