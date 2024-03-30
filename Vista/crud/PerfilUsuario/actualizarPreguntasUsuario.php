<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once ("../../../Modelo/Pregunta.php");
  //  require_once ("../../../Modelo/Bitacora.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   require_once("../../../Controlador/ControladorPregunta.php");
  //  require_once("../../../Controlador/ControladorBitacora.php");
   
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardarRespuestas"])) {
    // Verificar si se han recibido las respuestas
    if (isset($_POST["respuestas"])) {
        // Conectar a la base de datos (reemplaza los valores según tu configuración)
      
        // Intentar establecer la conexión
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        // Verificar la conexión
        if ($conexion === false) {
            die("Error de conexión: " . print_r(sqlsrv_errors(), true));
        }

        // Preparar la consulta de actualización
        $sql = "UPDATE tbl_MS_Preguntas_X_Usuario SET respuesta = '$respuesta' WHERE id_Pregunta = '$indice' AND Creado_Por = '$Usuario'";

        // Vincular parámetros y ejecutar la consulta para cada respuesta
        foreach ($_POST["respuestas"] as $indice => $respuesta) {
            $params = array($respuesta, $indice, $_SESSION["usuario"]); // Suponiendo que $_SESSION["usuario"] contiene el nombre del usuario
            $stmt = sqlsrv_query($conexion, $sql, $params);

            if ($stmt === false) {
                die("Error en la consulta: " . print_r(sqlsrv_errors(), true));
            }
        }

        // Cerrar la conexión
        sqlsrv_close($conexion);

        // Redireccionar o mostrar un mensaje de éxito
        echo "Respuestas actualizadas correctamente.";
    } else {
        echo "No se recibieron respuestas.";
    }
} else {
    // Si se accede directamente al script sin enviar el formulario
    echo "Acceso no autorizado.";
}
?>
