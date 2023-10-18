<?php
session_start();
// Desactivar el almacenamiento en caché en el lado del cliente
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si la sesión está iniciada antes de destruirla e si existe la url
if (isset($_SESSION["usuario"]) && isset($_GET['url'])) {
    // Destruir la sesión
    session_unset(); // Limpia todas las variables de sesión
    session_destroy(); // Destruye la sesión
    // Verifica si la url es 1 redirige a los metodos de recuperacion
    if($_GET['url'] == '1'){
        // Redirigir a la página de metodo de recuperacion
        header("Location: ./v_recuperarContrasena.html");
        exit(); // Asegurarse de que el script termine aquí
    }else{
        // Redirigir al login
        header("Location: ../login/login.php");
        exit(); // Asegurarse de que el script termine aquí
    }
}
?>