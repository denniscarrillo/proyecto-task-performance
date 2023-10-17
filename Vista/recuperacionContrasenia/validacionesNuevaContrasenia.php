<?php
  session_start();
  require_once ("../../db/Conexion.php");
  require_once ("../../Modelo/Usuario.php");
  require_once ("../../Modelo/Bitacora.php");
  require_once("../../Controlador/ControladorUsuario.php");
  require_once("../../Controlador/ControladorBitacora.php");
  $mensaje = '';
  //Primero se valida que exista una sesión, de lo contrario no se podra hacer nada y se le redigirá al login
  if (isset($_SESSION['usuario'])) {
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
    
    if (isset($_POST['submit'])){
      //Se valida que ya existe dicha variable y que no está vacia
      if (isset($_POST['current-password']) && !empty('current-password')) {
      //Obtenemos la contraseña del usuario desde la DB.
      $contraseniaActual = ControladorUsuario::login($user, $_POST['current-password']);
      //Validamos si la actual contraseña ingresada por el usuairo coincide con la del mismos en la DB.
      if($contraseniaActual){
        //Capturamos la nueva contraseña y validamos si ambas coinciden
        $password = $_POST['password'];
        $password1 = $_POST['confirmPassword'];
        if($password == $password1){  
          $encriptPassword = password_hash($password, PASSWORD_DEFAULT); 
          $estadoContra = ControladorUsuario::estadoValidacionContrasenas($user, $_POST['password']);
            if($estadoContra){
            $mensaje = 'Contraseña ya utilizada, elige otra';
            }else{                  
            //Actualizar a la nueva contraseña en la tabla usuario.
            ControladorUsuario::actualizarContrasenia($user, $encriptPassword);
            ControladorUsuario::reiniciarIntentosFallidosRespuesta($user);
            ControladorUsuario::desbloquearUsuario($user);  
            //Guardar contraseña anterior en la tabla historial contraseña.
            ControladorUsuario::respaldarContrasenia($user, "", $encriptPassword, 3);
            ControladorUsuario::eliminarUltimaContrasena($user);   
            $idUsuario = ControladorUsuario::obtenerIdUsuario($user);             
            header('location: ../login/login.php');
            session_destroy();
            }                                                
        } else {
          $mensaje = 'Deben coincidir ambas contraseñas!';
        }
      } else { //Si la contraseña actual ingresada es incorrecta se le mostrará el siguiente mensaje indicandolo
        $mensaje = 'Contraseña actual ingresada es incorrecta';
      }
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

