<?php
session_start(); //Reanudamos la sesion
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/CarteraClientes.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorCarteraClientes.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');

if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionCarteraClientes.php');
  //Se valida el usuario, si es SUPERADMIN por defecto tiene permiso caso contrario se valida el permiso vrs base de datos
  (!($_SESSION['usuario'] == 'SUPERADMIN'))
    ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual)
    :
    $permisoConsulta = true;
  ;
  if (!$permisoConsulta) {
    /* ==================== Evento intento de ingreso sin permiso a mantenimiento cartera clientes. =================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionCarteraClientes.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a mantenimiento cartera clientes';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  } else {
    if (isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])) {
      /* ====================== Evento salir. ================================================*/
      $accion = ControladorBitacora::accion_Evento();
      $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Exit'];
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de ' . $_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/
    }
    /* ============== Evento ingreso a mantenimiento cartera clientes. =======================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionCarteraClientes.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a mantenimiento cartera clientes';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionCarteraClientes.php';
    $_SESSION['descripcionObjeto'] = 'mantenimiento cartera clientes';
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
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../../Recursos/css/gestionCarteraClientes.css" rel="stylesheet" />
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Cartera Cliente </title>
</head>

<body style="overflow: hidden;">
  <div class="conteiner">
    <!-- Sidebar 1RA PARTE -->
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
        $comisionVendedor = '../ComisionesVendedores/ComisionesVendedores.php';
        $urlPorcentajes = '../Porcentajes/gestionPorcentajes.php';
        //Consulta
        $urlClientes = '../cliente/gestionCliente.php';
        $urlVentas = '../Venta/gestionVenta.php';
        $urlArticulos = '../articulo/gestionArticulo.php';
        $urlObjetos = '../DataTableObjeto/gestionDataTableObjeto.php';
        $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
        //Mantenimiento
        $urlUsuarios = '../usuario/gestionUsuario.php';
        $urlEstadoUsuario = '../estadoUsuario/gestionEstadoUsuario.php';
        $urlCarteraCliente = './gestionCarteraClientes.php';
        $urlPreguntas = '../pregunta/gestionPregunta.php';
        $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
        $urlParametros = '../parametro/gestionParametro.php';
        $urlPermisos = '../permiso/gestionPermisos.php';
        $urlRoles = '../rol/gestionRol.php';
        $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
        $urlImg = '../../../Recursos/' . ControladorParametro::obtenerUrlLogo();
        $urlPerfilUsuario = '../PerfilUsuario/gestionPerfilUsuario.php';
        $urlPerfilContraseniaUsuarios = '../PerfilUsuario/gestionPerfilContrasenia.php';
        $urlRazonSocial = '../razonSocial/gestionRazonSocial.php';
        $urlRubroComercial = '../rubroComercial/gestionRubroComercial.php';
        $urlRestoreBackup = '../backupAndRestore/gestionBackupRestore.php';
        require_once '../../layout/sidebar.php';
        ?>
      </div>
      <div class="conteiner-main">

        <!-- Encabezado -->
        <div class="encabezado">
          <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../../layout/navbar.php' ?>
          </div>
          <div class="titulo">
            <H1 class="title-dashboard-task"
              id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionCarteraClientes.php'); ?>">Gestión de Cartera
              de Clientes</H1>
          </div>
        </div>

        <H1></H1>
        <div class="table-conteiner">
          <div>
            <a href="#" class="btn_nuevoRegistro btn btn-primary hidden" id="btn_nuevoRegistro" data-bs-toggle="modal"
              data-bs-target="#modalNuevoCliente"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
            <!-- <a href="../../../TCPDF/examples/reporteriaCarteraCliente.php" target="_blank" class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a> -->
            <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
              PDF</button>
          </div>
          <table class="display nowrap table" id="table-CarteraClientes" style="width:100%">
            <thead>
              <tr>
                <th scope="col"> No. </th>
                <th scope="col"> NOMBRE </th>
                <th scope="col"> RTN </th>
                <th scope="col"> TELEFONO </th>
                <th scope="col"> CORREO </th>
                <th scope="col"> DIRECCION </th>
                <th scope="col"> ESTADO CONTACTO </th>
                <th scope="col"> ACCIONES </th>
              </tr>
            </thead>
            <div class="text-left mb-2">
            </div>
            <tbody class="table-group-divider">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php
  require_once('modalNuevoCliente.html');
  require_once('modalEditarCliente.html');
  ?>
  <!-- Librerias externas -->
  <script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <!-- scripts de validaciones -->
  <script src="../../../Recursos/js/CarteraClientes/datatable.js" type="module"></script>
  <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
  <script src="../../../Recursos/js/CarteraClientes/validacionesModalNuevoCliente.js" type="module"></script>
  <script src="../../../Recursos/js/CarteraClientes/validacionesModalEditarCliente.js" type="module"></script>
  <script src="../../../Recursos/js/index.js"></script>
</body>

</html>