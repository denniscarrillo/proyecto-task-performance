<?php
  require_once ("../../db/Conexion.php");
  require_once ("../../Modelo/Usuario.php");
  require_once ("../../Modelo/Bitacora.php");
  require_once("../../Controlador/ControladorUsuario.php");
  require_once("../../Controlador/ControladorBitacora.php");
  $mensaje = '';
  session_start();
  if (isset($_SESSION['usuario'])) {
    /* ========================= Evento Configurar Contraseña. ======================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('v_nuevaContrasenia.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingreso a pantalla configuración contraseña';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    
    if (isset($_POST['submit'])){
      $password = $_POST['password'];
      $password1 = $_POST['confirmPassword'];
      // session_start(); //Reanudamos sesion
      if(isset($_SESSION['usuario'])){
          $user = $_SESSION['usuario'];
          if($password == $password1){  
                  $encriptPassword = password_hash($password, PASSWORD_DEFAULT); 
                  $estadoContra = ControladorUsuario::estadoValidacionContrasenas($user, $_POST['password']);
                  // print json_encode($estadoContra, JSON_UNESCAPED_UNICODE);
                   if($estadoContra){
                    $mensaje = 'Contraseña ya utilizada, elige otra.';
                   }else{                  
                    //Actualizar a la nueva contraseña en la tabla usuario.
                    ControladorUsuario::actualizarContrasenia($user, $encriptPassword);
                    //Guardar contraseña anterior en la tabla historial contraseña.
                    $respaldada = ControladorUsuario::respaldarContrasenia($user, "", $encriptPassword, 3);
                    ControladorUsuario::eliminarUltimaContrasena($user);   
                    $idUsuario = ControladorUsuario::obtenerIdUsuario($user);
                    ControladorUsuario::desbloquearUsuario($idUsuario);               
                    header('location: ../login/login.php');
                    session_destroy();
                   }                                                
          } else {
            $mensaje = 'Deben coincidir ambas contraseñas!';
          }
          /* ========================= Evento Cambiar Contraseña. ======================*/
          $newBitacora = new Bitacora();
          $accion = ControladorBitacora::accion_Evento();
          date_default_timezone_set('America/Tegucigalpa');
          $newBitacora->fecha = date("Y-m-d h:i:s"); 
          $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('v_nuevaContrasenia.php');
          $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
          $newBitacora->accion = $accion['Insert'];
          $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' cambio su contraseña';
          ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
          /* =======================================================================================*/
      }
    }
  }

