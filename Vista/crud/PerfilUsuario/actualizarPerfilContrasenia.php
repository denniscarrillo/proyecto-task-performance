<?php
 require_once("../../../db/Conexion.php");
 require_once("../../../Modelo/Usuario.php");
 require_once("../../../Modelo/Bitacora.php");
 require_once("../../../Controlador/ControladorUsuario.php");
 require_once("../../../Controlador/ControladorBitacora.php");

 $mensaje = '';

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
      $NewPass= $_POST['newPassword'];
      $ConfirmPass = $_POST['confirmPassword'];
      
      //session_start(); //Reanudamos sesion
      if(isset($_SESSION['usuario'])){
          $user = $_SESSION['usuario'];
          $existeUsuario = ControladorUsuario::login($user, $_POST["password"]);
          if($existeUsuario){
            if($NewPass == $ConfirmPass){
              $encriptPassword = password_hash($NewPass, PASSWORD_DEFAULT);
             
              $estadoContra = ControladorUsuario::estadoValidacionContrasenas($user, $_POST['newPassword']);
                  // print json_encode($estadoContra, JSON_UNESCAPED_UNICODE);
                   if($estadoContra){
                    $mensaje = 'Elija una contraseña diferente,ya existe';
                   }else{ 
                    ControladorUsuario::actualizarContrasenia($user, $encriptPassword);

                    $respaldada = ControladorUsuario::respaldarContrasenia($user, "", $encriptPassword, 3); 
                    ControladorUsuario::eliminarUltimaContrasena($_SESSION['usuario']);
                    $mensaje = 'Contraseña Actualizada'; 
                   }                 
            } else {
              $mensaje = 'Deben coincidir ambas contraseñas!';
            }
          }else{
            $mensaje = 'Su contraseña actual es incorrecta';
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
?>

     