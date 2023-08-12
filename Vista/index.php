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
    <!-- Boostrap5 -->
  <link href='../Recursos/boostrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href='../Recursos/css/layout/sidebar.css' rel='stylesheet'>
<!--   para el index.css
 -->  <link href='../Recursos/css/index.css' rel='stylesheet'>
 
  <title>Dashboard</title>
</head>

<body>
  <div class="conteiner">
    <div class="row gx-0 row-conteiner">
      <!-- Menu lateral principal -->
      <div class="sb-conteiner col-2">
        <?php
        $urlIndex = 'index.php';
        $urlGestion = './crud/usuario/gestionUsuario.php';
        $urlTarea = './rendimiento/v_tarea.php';
        $urlSolicitud = './crud/solicitud/gestionSolicitud.php';
        $urlComision = './comisiones/v_comision.php';
        $urlVenta = './crud/venta/gestionVenta.php';
        $urlCliente = './crud/cliente/gestionCliente.php';
        $urlCarteraCliente = './crud/carteraCliente/gestionCarteraClientes.php';
        $urlCrudComision = './crud/comision/gestionComision.php';
        $urlRoles = '../../../Vista/crud/rol/gestionRol.php';
        $urlPreguntas = '../../../Vista/crud/pregunta/gestionPregunta.php';
        $urlBitacoras = '../../../Vista/crud/bitacora/gestionBitacora.php';
        
        require_once 'layout/sidebar.php';  
        ?>
      </div>

      <div class="content col-10">
              <?php
              require_once 'layout/navbar.php';
              ?>
      </div>          
  <div>
   <a class="btn_Venta" href="/Vista/crud/venta/gestionVenta.php"><i class="fa-solid fa-cash-register"></i> Ventas...</a>
 </div>
  <br>

  <div>
    <a class="btn_Rendimiento" href="#"><i class="fa-solid fa-square-poll-vertical"></i> Rendimiento...</a>
  </div>
  <br>

  <div>
   <a class="btn_Comisiones" href="/Vista/comisiones/v_comision.php"><i class="fa-solid fa-money-bill"></i>   Comisiones...</a>
  </div>
  <br>

  <div>
 <a class="btn_Clientes" href="/Vista/crud/cliente/gestionCliente.php"><i class="fa-solid fa-user-group"></i> Clientes...</a>
  </div>
  <br>

  <div>
<a class="btn_Mantenimiento" href="#"><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento...</a>
 </div>
<br>

<!-- para el boton de busqueda de la empresa -->
<div class="contenedor">
<a class="button_web" href="https://cocinasyequipos.com" target="_blank" ><i class="fa-solid fa-globe"></i> Cocinas y Equipos...</a>
<a class="button_fc" href="https://web.facebook.com/cyehn" target="_blank"> <i class="fa-brands fa-facebook"></i> Página de Facebook...</a>
<a class="button_ig" href="https://www.instagram.com/cocinasyequiposhn/" target="_blank"> <i class="fa-brands fa-instagram"></i> Página de Instagram...</a>
</div>
  </div>
</div> 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../Recursos/boostrap5/bootstrap.min.js"></script>
  <script src="../Recursos/js/index.js"></script>
</body>

</html>