<?php
  session_start();
  require_once ("../../db/Conexion.php");
  require_once ("../../Modelo/Usuario.php");
  require_once ("../../Modelo/Bitacora.php");
  require_once("../../Controlador/ControladorUsuario.php");
  require_once("../../Controlador/ControladorBitacora.php");
  $mensaje = '';
  //Primero se valida que exista una sesión, de lo contrario no se podra hacer nada y se le redigirá al login
  if (isset($_SESSION['usuario'])){
    $user = $_SESSION['usuario']; //Se captura el usuario de la sesión
    /* ========================= Evento ingresó a la vista Configurar Contraseña. ======================*/
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
    
    if (isset($_POST['submit'])) {
      $password = $_POST['password'];
      $password1 = $_POST['confirmPassword'];
      //Se valida que ya existe dicha variable y que no está vacia
      if (isset($_POST['current-password']) && !empty('current-password')) {
      //Obtenemos la contraseña del usuario desde la DB.
      $contraseniaActual = ControladorUsuario::login($user, $_POST['current-password']);
      //Validamos si la actual contraseña ingresada por el usuairo coincide con la del mismos en la DB.
      if($contraseniaActual){
        $mensaje = ejecutarCambiodeContrasenia($password, $password1, $user);
      } else { //Si la contraseña actual ingresada es incorrecta se le mostrará el siguiente mensaje indicandolo
        $mensaje = 'Contraseña actual ingresada es incorrecta';
      }
    } else {
      $mensaje = ejecutarCambiodeContrasenia($password, $password1, $user);
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
  } else {
    header("Location: ../login/login.php");
    exit(); // Asegurarse de que el script termine aquí
  }
  function ejecutarCambiodeContrasenia($password, $password1, $user){
    $mensaje = '';
    //Capturamos la nueva contraseña y validamos si ambas coinciden
    if($password == $password1){  
      $encriptPassword = password_hash($password, PASSWORD_DEFAULT); 
      $estadoContra = ControladorUsuario::estadoValidacionContrasenas($user, $password);
        if($estadoContra){
        $mensaje = 'Contraseña ya utilizada, elige otra';
        }else{                  
        //Actualizar a la nueva contraseña en la tabla usuario.
        ControladorUsuario::actualizarContrasenia($user, $encriptPassword);
        ControladorUsuario::reiniciarIntentosFallidos($user);
        ControladorUsuario::reiniciarIntentosFallidosRespuesta($user);
        ControladorUsuario::desbloquearUsuario($user);  
        //Guardar contraseña anterior en la tabla historial contraseña.
        ControladorUsuario::respaldarContrasenia($user, "", $encriptPassword, 3);
        ControladorUsuario::eliminarUltimaContrasena($user);   
        // $idUsuario = ControladorUsuario::obtenerIdUsuario($user); 
        session_destroy();            
        header('location: ../login/login.php');
        }                                                
    } else {
      $mensaje = 'Deben coincidir ambas contraseñas';
    }
    return $mensaje;
  }