<?php
  session_start();
  require_once('../../db/Conexion.php');
  require_once("../../Modelo/Bitacora.php");
  require_once("../../Controlador/ControladorBitacora.php");
  require_once('../../Modelo/Parametro.php');
  require_once('../../Controlador/ControladorParametro.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- <link href="../../../Recursos/css/gestionComision.css" rel="stylesheet" /> -->
  <link href='../../Recursos/css/estadisticas.css' rel='stylesheet'>
  <link href="../../Recursos/css/modalFiltroVendedor.css" rel="stylesheet" />
  <link href="../../Recursos/css/modalFiltroVendedor.css" rel="stylesheet" />

  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <title> Estadisticas </title>
</head>

<body style="overflow: hidden;">
  <div class="conteiner">
    <!-- Sidebar 1RA PARTE -->
    <div class="conteiner-global">
      <div class="sidebar-conteiner">
        <?php
        $urlIndex = '../index.php';
        // Rendimiento
        $urlMisTareas = '../rendimiento/v_tarea.php';
        $urlCotizacion = '../rendimiento/cotizacion/gestionCotizacion.php';
        $urlConsultarTareas = 'DataTableTarea/gestionDataTableTarea.php';
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
        $urlPerfilUsuario = '../crud/PerfilUsuario/gestionPerfilUsuario.php';
        $urlPerfilContraseniaUsuarios = '../crud/PerfilUsuario/gestionPerfilContrasenia.php';
        $urlImg = '../../Recursos/' . ControladorParametro::obtenerUrlLogo();
        $urlRazonSocial = '../crud/razonSocial/gestionRazonSocial.php';
        $urlRubroComercial = '../crud/rubroComercial/gestionRubroComercial.php';
        $urlArticulos = '../crud/gestionArticulo.php';
        $urlRestoreBackup = '../crud/backupAndRestore/gestionBackupRestore.php';
        require_once '../layout/sidebar.php';
        ?>
      </div>
      <div class="conteiner-main">
        <!-- Encabezado -->
        <div class="encabezado">
          <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../layout/navbar.php' ?>
          </div>
          <div class="titulo">
            <H2 class="title-dashboard-task" id="<?php echo $idObjetoActual; ?>">Estadísticas</H2>
          </div>
        </div>
        <div class="filtros">
          <div class="filtro-fecha">
            <label for="fechaDesde" class="date-label">Fecha desde:</label>
            <input type="date" id="fechaDesdef" name="fechaDesdef" class="form-control">
            <label for="fechaHasta" class="date-label">Fecha hasta:</label>
            <input type="date" id="fechaHastaf" name="fechaHastaf" class="form-control">
            <p class="mensaje"></p>
          </div>
          <div class="filtro-Input">
            <form>
              <fieldset>
                <legend>Elige el tipo</legend>
                <input type="radio" id="RadioGeneral" name="fav_language" value="General" checked>
                <label for="RadioGeneral" class="radio-label">General</label><br>
                <input type="radio" id="RadioPorVendedor" name="fav_language" value="Por Vendedor">
                <label for="RadioPorVendedor" class="radio-label">Por Vendedor</label><br>
              </fieldset>
            </form>
          </div>
          <div class="filtro-PorVendedor" id="PorVendedor">
            <label for="PorTarea" class="form-label label-select-vendedor">Seleccione un vendedor:</label>
            <button type="button" class="btn btn-success" id="btnVendedores" data-bs-toggle="modal"
              data-bs-target="#modalTraerVendedores" disabled>Seleccionar...<i
                class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i></button>
          </div>
          <button type="button" class="btn btn-info" id="btnFiltrar">Filtrar
            <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i></button>
        </div>
        <div class="table-conteiner">
          <div>
          <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
              PDF</button>
          </div>
          <table class="display nowrap table" id="table-Estadistica" style="width:100%">
            <thead>
              <tr>
                <th scope="col"> TAREA </th>
                <th scope="col"> META </th>
                <th scope="col"> ALCANCE </th>
                <th scope="col"> PORCENTAJE </th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php
      require_once('modalFiltroVendedores.html');
     ?>
  </div>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/permiso/dataTablePermisos.js" type="module"></script>
  <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
  <script src="../../Recursos/js/grafica/estadisticas.js"></script>

</body>

</html>