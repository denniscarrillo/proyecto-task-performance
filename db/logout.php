<?php
session_start();
// Desactivar el almacenamiento en caché en el lado del cliente
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si la sesión está iniciada antes de destruirla
if (isset($_SESSION["usuario"])) {
    // Destruir la sesión
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
?>