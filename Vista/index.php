<?php
require_once("../db/Conexion.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Bitacora.php");
require_once("../Controlador/ControladorUsuario.php");
require_once("../Controlador/ControladorBitacora.php");
require_once('../Modelo/Parametro.php');
require_once('../Controlador/ControladorParametro.php');

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  if (isset($_SESSION['objetoAnterior'])) {
    /* =============================== Evento salio del objeto. ============================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Exit'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de ' . $_SESSION['descripcionObjeto'];
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
  }
  /* ========================= Capturar evento inicio sesión. =============================*/
  $accion = ControladorBitacora::accion_Evento();
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('index.php');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a página principal';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  $_SESSION['objetoAnterior'] = 'index.php';
  $_SESSION['descripcionObjeto'] = 'página principal';
  /* =======================================================================================*/
} else {
  header('location: ./login/login.php');
  die();
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
  <!-- <link href='../Recursos/boostrap5/bootstrap.min.css' rel='stylesheet'> -->
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel='stylesheet' href='../Recursos/css/index.css'>
  <!-- Estilos layout -->
  <link rel='stylesheet' href='../Recursos/css/layout/navbar.css'>
  <link rel='stylesheet' href='../Recursos/css/layout/footer.css'>
  <link rel='stylesheet' href="../Recursos/css/layout/sidebar.css">
  <link rel='stylesheet' href="../Recursos/components/css/loader.css">
  <!-- ================================ -->
  <title>Dashboard</title>
</head>

<body style="overflow: hidden;">
  <div class="loader-section">
    <span class="loader"></span>
  </div>
  <!-- Sidebar -->
  <div class="conteiner-global">
    <div class="sidebar-conteiner">
      <?php
      $urlIndex = './index.php';
      // Rendimiento
      $urlMisTareas = './rendimiento/v_tarea.php';
      $urlCotizacion = './rendimiento/cotizacion/gestionCotizacion.php';
      $urlConsultarTareas = './crud/DataTableTarea/gestionDataTableTarea.php';
      $urlMetricas = './crud/Metricas/gestionMetricas.php';
      $urlEstadisticas = './grafica/estadistica.php';
      //Solicitud
      $urlSolicitud = './crud/DataTableSolicitud/gestionDataTableSolicitud.php';
      //Comisión
      $urlComision = './comisiones/v_comision.php';
      $urlPorcentajes = './crud/Porcentajes/gestionPorcentajes.php';
      $comisionVendedor = './crud/ComisionesVendedores/ComisionesVendedores.php';
      //Consulta
      $urlClientes = './crud/cliente/gestionCliente.php';
      $urlVentas = './crud/Venta/gestionVenta.php';
      $urlArticulos = './crud/articulo/gestionArticulo.php';
      $urlObjetos = './crud/DataTableObjeto/gestionDataTableObjeto.php';
      //Mantenimiento
      $urlUsuarios = './crud/usuario/gestionUsuario.php';
      $urlEstadoUsuario = './crud/estadoUsuario/gestionEstadoUsuario.php';
      $urlCarteraCliente = './crud/carteraCliente/gestionCarteraClientes.php';
      $urlPreguntas = './crud/pregunta/gestionPregunta.php';
      $urlBitacoraSistema = './crud/bitacora/gestionBitacora.php';
      $urlParametros = './crud/parametro/gestionParametro.php';
      $urlPermisos = './crud/permiso/gestionPermisos.php';
      $urlRoles = './crud/rol/gestionRol.php';
      $urlServiciosTecnicos = './crud/TipoServicio/gestionTipoServicio.php';
      $urlPerfilUsuario = './crud/PerfilUsuario/gestionPerfilUsuario.php';
      $urlPerfilContraseniaUsuarios = './crud/PerfilUsuario/gestionPerfilContrasenia.php';
      $urlEditarCamposPerfil = './crud/PerfilUsuario/EditarCamposPerfilUsuario.php';
      $urlImg = '/Recursos/' . ControladorParametro::obtenerUrlLogo();
      $urlRazonSocial = './crud/RazonSocial/gestionRazonSocial.php';
      $urlRubroComercial = './crud/RubroComercial/gestionRubroComercial.php';
      require_once 'layout/sidebar.php';
      ?>
    </div>
    <div class="conteiner-main">
      <div class="navbar-conteiner">
        <!-- Aqui va la barra -->
        <?php include_once './layout/navbar.php' ?>
      </div>
      <!-- Cuerpo de la pagina -->
      <main class="main">
        <!-- Contenedor de los enlaces de los modulos -->
        <div class="conteiner-link">
          <a class="card-link" href="rendimiento/v_tarea.php"><i class="fa-solid fa-clipboard-list icon-size"></i>
            <p>Tareas</p>
          </a>
          <a class="card-link" href="comisiones/v_comision.php"><i
              class="fa-solid fa-file-invoice-dollar icon-size"></i>
            <p>Comisiones</p>
          </a>
          <a class="card-link" href="crud/DataTableSolicitud/gestionDataTableSolicitud.php"><i
              class="fa-solid fa-envelopes-bulk icon-size"></i>
            <p>Solicitud</p>
          </a>
          <a class="card-link" href="crud/Venta/gestionVenta.php"><i class="fa-solid fa-cash-register icon-size"></i>
            <p>Ventas</p>
          </a>
          <a class="card-link" href="crud/articulo/gestionArticulo.php"><i
              class="fa-solid fa-kitchen-set icon-size"></i>
            <p>Artículos</p>
          </a>
          <a class="card-link" href="crud/carteraCliente/gestionCarteraClientes.php"><i class="fa-solid fa-user-group icon-size"></i>
            <p>Clientes</p>
          </a>
        </div>
      </main>
      <!-- Footer -->
      <div class="footer-conteiner">
        <?php
        require_once 'layout/footer.php';
        ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <!-- <script src="../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../Recursos/js/validacionesSidebar.js"></script> -->
  <script src="../Recursos/components/js/loader.js" type="module"></script>
  <script src="../Recursos/js/index.js"></script>
</body>

</html>