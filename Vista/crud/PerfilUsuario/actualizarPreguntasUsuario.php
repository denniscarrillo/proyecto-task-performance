<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once ("../../../Modelo/Pregunta.php");
  //  require_once ("../../../Modelo/Bitacora.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   require_once("../../../Controlador/ControladorPregunta.php");
  //  require_once("../../../Controlador/ControladorBitacora.php");
   
  if (isset($_POST['respuestas']) && isset($_SESSION['usuario'])) {
      $user = $_SESSION['usuario'];
      $Respuestas = $_POST['respuestas'];/*json decode convierte en array*/
      ControladorPregunta::actualizarRespuesta($Respuestas, $user); 
      var_dump($Respuestas);
  } else {
      // Manejar el caso en que la sesión no está configurada correctamente
    
  }
  
?>