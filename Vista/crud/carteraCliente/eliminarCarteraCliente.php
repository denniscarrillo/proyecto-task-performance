<?php
    session_start(); //Reanudamos session
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");

    if(isset($_SESSION['usuario'])){
      $eliminado = ControladorCarteraClientes::eliminarCliente($_POST['rtn']);
      print json_encode(['estado' => $eliminado], JSON_UNESCAPED_UNICODE);
      /* ========================= Evento Editar cartera cliente. ======================*/
      $newBitacora = new Bitacora();
      $accion = ControladorBitacora::accion_Evento();
      $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionCarteraClientes.php');
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      if($eliminado){
        $eliminar = " eliminó ";
        $newBitacora->accion = $accion['Delete'];
    }else{
        $eliminar = " intentó eliminar ";
        $newBitacora->accion = $accion['tryDelete'];
    }
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].$eliminar.' al cliente '.$_POST['nombreCliente'].' con RTN '.$_POST['rtn'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/
    }