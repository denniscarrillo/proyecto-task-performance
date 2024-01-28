<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Comision.php");
require_once("../../../Controlador/ControladorComision.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('ComisionesVendedores.php');
  //Se valida el usuario, si es SUPERADMIN por defecto tiene permiso caso contrario se valida el permiso vrs base de datos
  (!($_SESSION['usuario'] == 'SUPERADMIN'))
    ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual)
    :
    $permisoConsulta = true;
  ;
  if (!$permisoConsulta) {
    /* ====================== Evento intento de ingreso sin permiso a la vista comisiones por vendedor. ================================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('ComisionesVendedores.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a la vista de comisiones por vendedor';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  } else {
    if (isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])) {
      /* ====================== Evento salir. ================================================*/
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s");
      $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Exit'];
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de ' . $_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/
    }
    /* ====================== Evento ingreso a vista comisiones por vendedor. =====================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('ComisionesVendedores.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a vista de comisiones por vendedor';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'ComisionesVendedores.php';
    $_SESSION['descripcionObjeto'] = 'vista de comisiones por vendedor';
    /* =======================================================================================*/
  }
} else {
  header('location: ../../login/login.php');
  die();
}
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
  <link href="../../../Recursos/css/ComisionesVendedores.css" rel="stylesheet" />
  <link href="../../../Recursos/css/gestionComision.css" rel="stylesheet" />
  <!-- <link href="../../../Recursos/css/modalNuevaComision.css" rel="stylesheet"> -->
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Comisiones Por Vendedores </title>
</head>

<body style="overflow: hidden;">

  <!-- Sidebar 1RA PARTE -->
  <div class="conteiner">
    <div class="conteiner-global">
      <div class="sidebar-conteiner">
        <?php
        $urlIndex = '../../index.php';
        // Rendimiento
        $urlMisTareas = '../../rendimiento/v_tarea.php';
        $urlCotizacion = '../../rendimiento/cotizacion/gestionCotizacion.php';
        $urlConsultarTareas = '../DataTableTarea/gestionDataTableTarea.php';
        $urlMetricas = '../Metricas/gestionMetricas.php';
        $urlEstadisticas = '../../grafica/estadistica.php';
        //Solicitud
        $urlSolicitud = '../DataTableSolicitud/gestionDataTableSolicitud.php';
        //Comisión
        $urlComision = '../../comisiones/v_comision.php';
        $comisionVendedor = './ComisionesVendedores.php';
        $urlPorcentajes = '../Porcentajes/gestionPorcentajes.php';
        //Consulta
        $urlClientes = '../cliente/gestionCliente.php';
        $urlVentas = '../Venta/gestionVenta.php';
        $urlArticulos = '../articulo/gestionArticulo.php';
        $urlObjetos = '../DataTableObjeto/gestionDataTableObjeto.php';
        //Mantenimiento
        $urlUsuarios = '../usuario/gestionUsuario.php';
        $urlEstadoUsuario = '../estadoUsuario/gestionEstadoUsuario.php';
        $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
        $urlPreguntas = '../pregunta/gestionPregunta.php';
        $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
        $urlParametros = '../parametro/gestionParametro.php';
        $urlPermisos = '../permiso/gestionPermisos.php';
        $urlRoles = '../rol/gestionRol.php';
        $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
        $urlImg = '../../../Recursos/' . ControladorParametro::obtenerUrlLogo();
        $urlRazonSocial = '../razonSocial/gestionRazonSocial.php';
        $urlRubroComercial = '../rubroComercial/gestionRubroComercial.php';
        require_once '../../layout/sidebar.php';
        ?>
      </div>

      <!-- CONTENIDO DE LA PAGINA - 2RA PARTE -->
      <div class="conteiner-main">

        <!-- Encabezado -->
        <div class="encabezado">
          <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../../layout/navbar.php' ?>
          </div>
          <div class="titulo">
            <h2 class="title-dashboard-task">Comisiones Por Vendedores</h2>
          </div>
        </div>
        <div class="table-conteiner">
          <div class="filtros">
            <div class="filtro-fecha">
              <label for="fechaDesde">Fecha desde:</label>
              <input type="date" id="fechaDesdef" name="fechaDesdef" class="form-control">
              <label for="fechaHasta">Fecha hasta:</label>
              <input type="date" id="fechaHastaf" name="fechaHastaf" class="form-control">
              <button type="button" class="btn btn-primary" id="btnFiltrar">Sumar Comisiones</button>
            </div>
            <div>
              <!-- <a href="ComisionPorVendedor.php" class="btn_nuevoRegistro btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Comision total por vendedor</a> -->
              <!-- <a href="../../../TCPDF/examples/reporteriaComisionVendedores.php" class="btn_Pdf btn btn-primary hidden" id= "btn_Pdf"><i class="fas fa-file-pdf"></i>
                Generar Reportes</a> -->
              <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
                PDF</button>
            </div>
            <table class="display nowrap table" id="table-ComisionVendedor" style="width:100%">
              <thead>
                <tr>
                  <th scope="col">ID COMISION VENDEDOR</th>
                  <th scope="col">ID COMISION</th>
                  <th scope="col">ID VENDEDOR</th>
                  <th scope="col">VENDEDOR</th>
                  <th scope="col">COMISION TOTAL</th>
                  <th scope="col">ESTADO </th>
                  <th scope="col">LIQUIDACION</th>
                  <!-- <th scope="col">ESTADO COBRO VENTA</th>
                  <th scope="col">METODO PAGO</th> -->
                  <th scope="col">FECHA CREACION</th>
                  <th scope="col">FECHA LIQUIDACION</th>
                  <!-- <th scope="col">FECHA COBRO</th> -->
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
    // require('modalFiltroComisiones.html');
    require('modalComisionesV.html');
    ?>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="../../../Recursos/js/comision/dataTableComision_V.js" type="module"></script>
    <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
    <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
    <script src="../../../Recursos/js/index.js"></script>
    <!-- <script src="../../../Recursos/js/validacionesModalNuevoUsuario.js"  type="module"></script>
<script src="../../../Recursos/js/validacionesModalEditarUsuario.js" type="module"></script> -->
</body>

</html>