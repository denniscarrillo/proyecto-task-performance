<?php
require_once("./Conexion.php");
require_once("../Modelo/Bitacora.php");
require_once("../Modelo/Usuario.php");
require_once("../Controlador/ControladorPregunta.php");
require_once("../Controlador/ControladorBitacora.php");
require_once("../Controlador/ControladorUsuario.php");
session_start();
// Desactivar el almacenamiento en caché en el lado del cliente
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si la sesión está iniciada antes de destruirla
if (isset($_SESSION["usuario"])) {
    // Destruir la sesión
    /* ========================= Evento Cerrar sesión. ==================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('LOGIN.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION["usuario"]);
    $newBitacora->accion = $accion['Logout'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION["usuario"].' cerró sesión';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    session_unset(); // Limpia todas las variables de sesión
    session_destroy(); // Destruye la sesión
    // Redirigir a la página de inicio de sesión
    header("Location: ../Vista/login/login.php");
    exit(); // Asegurarse de que el script termine aquí
} else {
    // Si la sesión no está iniciada, redirigir a la página de inicio de sesión también
    header("Location: ../Vista/login/login.php");
    exit();
}