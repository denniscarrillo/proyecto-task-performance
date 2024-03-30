<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Articulo.php");
require_once("../../../Controlador/ControladorArticulo.php");
require_once('../../../Modelo/Usuario.php');
require_once('../../../Controlador/ControladorUsuario.php');
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionArticulo.php');
  //Se valida el usuario, si es SUPERADMIN por defecto tiene permiso caso contrario se valida el permiso vrs base de datos
  (!($_SESSION['usuario'] == 'SUPERADMIN')) 
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
    $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ====================== Evento intento de ingreso sin permiso a vista de artículos. ===========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionArticulo.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a vista de artículos';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  }else{
    if(isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])){
      /* ====================== Evento salir. ================================================*/
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s");
      $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Exit'];
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de '.$_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    }
    /* ====================== Evento ingreso avista de artículos. ===========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionArticulo.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a vista de artículos';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionArticulo.php';
    $_SESSION['descripcionObjeto'] = 'vista de artículos';
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
  <!-- <link href="../../../Recursos/css/gestionUsuario.css" rel="stylesheet" />-->
  <link href="../../../Recursos/css/gestionArticulos.css" rel="stylesheet" />
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Articulos </title>
</head>

<body style="overflow: hidden;">
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
          $urlArticulos = './gestionArticulo.php';
          $urlObjetos = '../DataTableObjeto/gestionDataTableObjeto.php';
          $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
          //Mantenimiento
          $urlUsuarios = '../usuario/gestionUsuario.php';
          $urlEstadoUsuario = '../estadoUsuario/gestionEstadoUsuario.php';
          $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
          $urlPreguntas = '../pregunta/gestionPregunta.php';
          $urlParametros = '../parametro/gestionParametro.php';
          $urlPermisos = '../permiso/gestionPermisos.php';
          $urlRoles = '../rol/gestionRol.php';
          $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
          $urlImg = '../../../Recursos/' . ControladorParametro::obtenerUrlLogo();
          $urlPerfilUsuario='../PerfilUsuario/gestionPerfilUsuario.php';
          $urlPerfilContraseniaUsuarios='../PerfilUsuario/gestionPerfilContrasenia.php';
          $urlRazonSocial = '../RazonSocial/gestionRazonSocial.php';
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
          <?php include_once '../../layout/navbar.php'?>
        </div>
        <div class="titulo">
          <H2 class="title-dashboard-task"
            id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionArticulo.php');?>">Gestión de Articulos</H2>
        </div>
      </div>

      <div class="table-conteiner">
        <div>
          <a href="#" class="btn_nuevoRegistro btn btn-primary hidden" id="btn_nuevoRegistro" data-bs-toggle="modal"
            data-bs-target="#modalNuevoArticulo"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
          <!-- <a href="../../../TCPDF/examples/reporteriaArticulos.php" class="btn_Pdf btn btn-primary hidden" target="_blank"  id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a> -->
          <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
            PDF</button>
        </div>
        <table class="display nowrap table" id="table-Articulos" style="width:100%">
          <thead>
            <tr>
              <th scope="col"> COD. ARTÍCULO</th>
              <th scope="col"> ARTÍCULO </th>
              <th scope="col"> DETALLE </th>
              <th scope="col"> PRECIO </th>
              <th scope="col"> EXISTENCIAS </th>
              <th scope="col"> MARCA </th>
              <th scope="col"> CREADO POR </th>
              <th scope="col"> FECHA CREACIÓN </th>
              <th scope="col"> ACCIONES</th>
            </tr>
          </thead>
          <!-- <div class ="text-left mb-2">
              <a href="../../fpdf/ReporteClientes.php" target="_blank" class="btn btn-success" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a>
              </div> -->
          <tbody class="table-group-divider">
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
  <?php
  require_once('modalNuevoArticulo.html');
  require_once('modalEditarArticulo.html');
  
  ?>

<script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>

<!-- scripts propios -->
  <script src="../../../Recursos/js/articulo/ValidacionesModalNuevoArticulo.js" type="module"></script>
  <script src="../../../Recursos/js/articulo/ValidacionesModalEditarArticulo.js" type="module"></script>
  <script src="../../../Recursos/js/articulo/dataTableArticulo.js" type="module"></script>
  <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
</body>

</html>