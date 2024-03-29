<?php
require_once('validacionesTarea.php');
require_once('../../Modelo/Parametro.php');
require_once('../../Controlador/ControladorParametro.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <!-- Boostrap5 -->
  <link rel='stylesheet' href='../../Recursos/bootstrap5/bootstrap.min.css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="../../Recursos/css/tarea.css">
  <link rel="stylesheet" href="../../Recursos/css/modalEditarTarea.css">
  <link rel="stylesheet" href="../../Recursos/css/index.css">
  <!-- Estilos layout -->
  <link rel='stylesheet' href='../../Recursos/css/layout/navbar.css'>
  <link rel="stylesheet" href="../../Recursos/css/layout/sidebar.css">
  <link rel='stylesheet' href="../../Recursos/components/css/loader.css">
  <!-- ================================ -->
  <title>Tareas</title>
</head>

<body>
  <div class="loader-section">
    <span class="loader"></span>
  </div>
  <div class="conteiner-global">
    <div class="sidebar-conteiner sidebar locked">
      <?php
      $urlIndex = '../index.php';
      // Rendimiento
      $urlMisTareas = './v_tarea.php';
      $urlCotizacion = './cotizacion/gestionCotizacion.php';
      $urlConsultarTareas = '../crud/DataTableTarea/gestionDataTableTarea.php';
      $urlMetricas = '../crud/Metricas/gestionMetricas.php';
      $urlEstadisticas = '../grafica/estadistica.php';
      //Solicitud
      $urlSolicitud = '../crud/DataTableSolicitud/gestionDataTableSolicitud.php';
      //Comisión
      $urlComision = '../comisiones/v_comision.php';
      $comisionVendedor = '../crud/ComisionesVendedores/ComisionesVendedores.php';
      $urlPorcentajes = '../crud/Porcentajes/gestionPorcentajes.php';
      //Consulta
      $urlClientes = '../crud/cliente/gestionCliente.php';
      $urlVentas = '../crud/Venta/gestionVenta.php';
      $urlArticulos = '../crud/articulo/gestionArticulo.php';
      $urlObjetos = '../crud/DataTableObjeto/gestionDataTableObjeto.php';
      $urlBitacoraSistema = '../crud/bitacora/gestionBitacora.php';
      //Mantenimiento
      $urlUsuarios = '../crud/usuario/gestionUsuario.php';
      $urlEstadoUsuario = '../crud/estadoUsuario/gestionEstadoUsuario.php';
      $urlCarteraCliente = '../crud/carteraCliente/gestionCarteraClientes.php';
      $urlPreguntas = '../crud/pregunta/gestionPregunta.php';
      $urlParametros = '../crud/parametro/gestionParametro.php';
      $urlPermisos = '../crud/permiso/gestionPermisos.php';
      $urlRoles = '../crud/rol/gestionRol.php';
      $urlServiciosTecnicos = '../crud/TipoServicio/gestionTipoServicio.php';
      $urlPerfilUsuarios = '../crud/PerfilUsuario/gestionPerfilUsuario.php';
      $urlPerfilContraseniaUsuarios = '../crud/PerfilUsuario/gestionPerfilContrasenia.php';
      $urlImg = '../../Recursos/' . ControladorParametro::obtenerUrlLogo();
      $urlRazonSocial = '../crud/razonSocial/gestionRazonSocial.php';
      $urlRubroComercial = '../crud/rubroComercial/gestionRubroComercial.php';
      require_once '../layout/sidebar.php';
      ?>
    </div>
    <div class="tareas-main">
      <div class="navbar-conteiner">
        <!-- Aqui va la barra -->
        <?php include_once '../layout/navbar.php' ?>
      </div>
      <!-- Cuerpo de la pagina -->
      <main class="main-tareas">
        <div class="encabezado">
          <h2 class="title-dashboard-task" id="<?php echo ControladorBitacora::obtenerIdObjeto('v_tarea.php'); ?>"
            name='v_tarea.php'>Tablero | Mis tareas</h2>
        </div>
        <div class="task-conteiner">
          <div class="colum-task-conteiner">
            <!-- COLUMNA LLAMADAS -->
            <div class="task-colum" id="columna-llamadas">
              <div class="title-task">
                <p class="title-task-label">Llamada</p>
                <p class="circle-count" id="circle-count-llamadas"></p>
              </div>
              <div class="container_tarea dragged-conteiner" id="conteiner-llamada">
                <!-- Aqui van las tareas llamadas -->
              </div>
              <button type="button" class="btn_nuevaTarea btn btn-primary btn_nuevoRegistro hidden"
                id="btn-NuevaLLamada">+ Nueva llamada</button>
            </div>
            <!-- COLUMNA LEADS -->
            <div class="task-colum" id="columna-leads">
              <div class="title-task">
                <p class="title-task-label">Lead</p>
                <p class="circle-count" id="circle-count-leads"></p>
              </div>
              <button type="button" class="btn_nuevaTarea btn btn-primary btn_nuevoRegistro hidden" id="btn-NuevoLead">+
                Nuevo lead</button>
              <div class="container_tarea dragged-conteiner" id="conteiner-lead">
                <!-- Aqui van las tareas leads -->
              </div>
            </div>
            <!-- COLUMNA COTIZACIONES -->
            <div class="task-colum" id="columna-cotizaciones">
              <div class="title-task">
                <p class="title-task-label">Cotización</p>
                <p class="circle-count" id="circle-count-cotizaciones"></p>
              </div>
              <button type="button" class="btn_nuevaTarea btn btn-primary btn_nuevoRegistro hidden"
                id="btn-NuevaCotizacion">+ Nueva cotización</button>
              <div class="container_tarea dragged-conteiner" id="conteiner-cotizacion">
                <!-- Aqui van las tareas leads -->
              </div>
              <!-- <button>+ Nueva Tarea</button> -->
            </div>
            <!-- COLUMNA VENTAS -->
            <div class="task-colum" id="columna-ventas">
              <div class="title-task">
                <p class="title-task-label">Venta</p>
                <p class="circle-count" id="circle-count-ventas"></p>
              </div>
              <button type="button" class="btn_nuevaTarea btn btn-primary btn_nuevoRegistro hidden"
                id="btn-NuevaVenta">+ Nueva venta</button>
              <div class="container_tarea dragged-conteiner" id="conteiner-venta">
                <!-- Aqui van las tareas tipo ventas -->
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <div id="modals-container">
    <?php
    require_once('modalVendedores.html');
    ?>
  </div>
  <script src="../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js"></script>
  <script src="../../Recursos/js/librerias/SweetAlert2.all.min.js"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../Recursos/js/librerias/dataTables.bootstrap5.min.js"></script>
  <script src="../../Recursos/js/librerias/Sortable.min.js"></script>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js "></script>
  <!-- Scripts personalizados -->
  <script src="../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
  <script src="../../Recursos/components/js/loader.js" type="module"></script>
  <script src="../../Recursos/js/rendimiento/tarea.js" type="module"></script>
</body>

</html>