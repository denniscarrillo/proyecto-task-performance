<?php
require_once("validacionesComision.php");
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
  <link href='../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../Recursos/css/gestionComision.css" rel="stylesheet" />
  <link href='../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../Recursos/css/modalVerIdComision.css' rel='stylesheet'>
  <link href='../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../Recursos/css/layout/footer.css' rel='stylesheet'>
  
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Comision </title>
</head>

<body style="overflow: hidden;">
  <div class="conteiner">
    <div class="conteiner-global">
      <div class="sidebar-conteiner">
        <?php
        $urlIndex = '../index.php';
        // Rendimiento
        $urlMisTareas = '../rendimiento/v_tarea.php';
        $urlConsultarTareas = '../crud/DataTableTarea/gestionDataTableTarea.php';
        $urlBitacoraTarea = ''; //PENDIENTE
        $urlMetricas = '../crud/Metricas/gestionMetricas.php';
        $urlEstadisticas = '../grafica/estadistica.php'; //PENDIENTE
        //Solicitud
        $urlSolicitud = '../crud/DataTableSolicitud/gestionDataTableSolicitud.php';
        //Comisión
        $urlComision = './v_comision.php';
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
        $urlPerfilUsuario = '../PerfilUsuario/gestionPerfilUsuario.php';
        $urlPerfilContraseniaUsuarios = '../PerfilUsuario/gestionPerfilContrasenia.php';
        $urlImg = '../../Recursos/' . ControladorParametro::obtenerUrlLogo();
        $urlRazonSocial = '../crud/RazonSocial/gestionRazonSocial.php';
        $urlRubroComercial = '../crud/rubroComercial/gestionRubroComercial.php';
        require_once '../layout/sidebar.php';
        ?>
      </div>
      <!-- CONTENIDO DE LA PAGINA - 2RA PARTE -->
      <div class="conteiner-main">

        <!-- Encabezado -->
        <div class="encabezado">
          <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../layout/navbar.php' ?>
          </div>
          <div class="titulo">
            <H2 class="title-dashboard-task" id="<?php echo ControladorBitacora::obtenerIdObjeto('v_comision.php'); ?>">
              Comisiones</H2>
          </div>
        </div>
        <div class="table-conteiner">
          <div class="filtros">
            <!-- <div class="filtro-fecha">
              <label for="fechaDesde">Fecha desde:</label>
              <input type="date" id="fechaDesdef" name="fechaDesdef" class="form-control">
              <label for="fechaHasta">Fecha hasta:</label>
              <input type="date" id="fechaHastaf" name="fechaHastaf" class="form-control">
              <button type="button" class="btn btn-primary" id="btn_filtroALiquidar">Comisiones a liquidar</button>
            </div> -->
            <div>
              <a href="v_nuevaComision.php" class="btn_nuevoRegistro btn btn-primary hidden" id="btn_nuevoRegistro"><i
                  class="fa-solid fa-circle-plus"></i> Generar comisión</a>
              <!-- <a href="../../../TCPDF/examples/reporteriaComision.php" class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"><i class="fas fa-file-pdf"></i>
                Generar Reportes</a> -->
              <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
                PDF</button>
              <!-- <a href="ReporteComisionExcel.php" target="_blank" class="btn_Excel btn btn-primary "><i
                  class="fa-solid fa-file-excel fa-sm"></i> Generar Excel</a> -->
            </div>
            <table class="display nowrap table" id="table-Comision" style="width:100%">
              <thead>
                <tr>
                  <th scope="col"> No. COMISION </th>
                  <th scope="col"> No. FACTURA </th>
                  <th scope="col"> TOTAL VENTA </th>
                  <th scope="col"> PORCENTAJE </th>
                  <th scope="col"> COMISIÓN TOTAL </th>
                  <th scope="col"> ESTADO COMISIÓN </th>
                  <th scope="col"> ESTADO LIQUIDACIÓN </th>
                  <!-- <th scope="col"> ESTADO COBRO </th>
                  <th scope="col"> METODO PAGO </th> -->
                  <th scope="col"> FECHA CREACIÓN </th>
                  <th scope="col"> FECHA LIQUIDACIÓN</th>
                  <!-- <th scope="col"> FECHA COBRO VENTA </th> -->
                  <th scope="col"> ACCIONES </th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php
    // require_once('modalFiltroVenta.html');
    
    require_once('modalVerComisiones.html');
    require_once('modalEditarComision.html');
    require_once('modalLiquidarComisiones.html');


    ?>
    <script src="../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
    <script src="../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
    <script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
    <script src="../../Recursos/js/comision/dataTableComision.js" type="module"></script>
    <script src="../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
    <!-- <script src="../../Recursos/js/comision/validacionesEditarComision.js" type="module"></script> -->
    <!-- <script src="../../Recursos/js/permiso/dataTablePermisos.js"></script> -->
    <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../../Recursos/bootstrap5/bootstrap.min.js"></script>
    <script src="../../Recursos/js/index.js"></script>

</body>

</html>