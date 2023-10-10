

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
      $ConfirmPass = $_POST['confirmPassword'];
      
      //session_start(); //Reanudamos sesion
      if(isset($_SESSION['usuario'])){
          $user = $_SESSION['usuario'];
          $existeUsuario = ControladorUsuario::login($user, $_POST["confirmPassword"]);
          if($existeUsuario){
            header('location: EditarCamposPerfilUsuario.php');
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

     