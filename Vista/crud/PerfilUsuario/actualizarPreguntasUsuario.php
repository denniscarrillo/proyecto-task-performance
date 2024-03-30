<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once ("../../../Modelo/Pregunta.php");
  //  require_once ("../../../Modelo/Bitacora.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   require_once("../../../Controlador/ControladorPregunta.php");
  //  require_once("../../../Controlador/ControladorBitacora.php");
  $respuestas = []; // Inicializar $respuestas como un array vacío
if(isset($_POST['respuestas'])) {
    $respuestas = $_POST['respuestas'];
} 
  if(isset($_SESSION['usuario'])) {
   $user = $_SESSION['usuario'];
   ControladorPregunta::actualizarRespuesta($user, $respuestas);
} else {
   // Manejar el caso en que la sesión no está configurada correctamente
   echo "La sesión de usuario no está configurada correctamente.";
}

?>