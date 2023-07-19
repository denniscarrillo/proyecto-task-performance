<?php
require_once("../db/Conexion.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Bitacora.php");
require_once("../Controlador/ControladorUsuario.php");
require_once("../Controlador/ControladorBitacora.php");
session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  /* ========================= Capturar evento inicio sesión. =============================*/
  $newBitacora = new Bitacora();
  $accion = ControladorBitacora::accion_Evento();
  date_default_timezone_set('America/Tegucigalpa');
  $newBitacora->fecha = date("Y-m-d h:i:s");
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('index.php');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingreso al menú principal';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  /* =======================================================================================*/
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <link href='../Recursos/boostrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href='../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <title>Dashboard</title>
</head>

<body>
  <div class="conteiner">
    <div class="row gx-0">
      <!-- Menu lateral principal -->
      <div class="sb-conteiner col-2">
        <?php
        $urlIndex = 'index.php';
        $urlGestion = './crud/usuario/gestionUsuario.php';
        $urlTarea = './rendimiento/v_tarea.php';
        $urlSolicitud = './crud/solicitud/gestionSolicitud.php';
        $urlComision = './crud/comision/gestionComision.php';
        $urlVenta = './crud/venta/gestionVenta.php';
        $urlCliente ='./crud/cliente/gestionCliente.php';
        $urlCarteraCliente = './crud/carteraCliente/gestionCarteraClientes.php';
        require_once 'layout/sidebar.php';
        ?>
      </div>
      <div class="content col-10">
        <div class="cards">
        </div>
      </div>
    </div>
  </div>
  <script src="../Recursos/boostrap5/bootstrap.min.js"></script>
  <script src="../Recursos/js/index.js"></script>
</body>
</html>