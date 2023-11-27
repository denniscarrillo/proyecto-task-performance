<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Tarea.php");
require_once("../../../Controlador/ControladorTarea.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionCotizacion.php');
  (!($_SESSION['usuario'] == 'SUPERADMIN'))
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
    $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ==================== Evento intento de ingreso sin permiso a mantenimiento pregunta. ==========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionCotizacion.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a gestión cotización';
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
    /* ====================== Evento ingreso a mantenimiento pregunta. ========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionCotizacion.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a gestión cotización';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionPregunta.php';
    $_SESSION['descripcionObjeto'] = 'gestión cotización';
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
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <link href="../../../Recursos/css/gestionCarteraClientes.css" rel="stylesheet" />
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Ver Cotizaciones </title>
</head>

<body style="overflow: hidden;">

  <!-- Sidebar 1RA PARTE -->
  <div class="conteiner">
    <div class="conteiner-global">
      <div class="sidebar-conteiner">
      <?php
          $urlIndex = '../../index.php';
          // Rendimiento
          $urlMisTareas = '../v_tarea.php';
          $urlCotizacion = './gestionCotizacion.php';
          $urlConsultarTareas = '../../crud/DataTableTarea/gestionDataTableTarea.php';
          $urlMetricas = '../../crud/Metricas/gestionMetricas.php';
          $urlEstadisticas = '../../grafica/estadistica.php'; 
          //Solicitud
          $urlSolicitud = '../../crud/DataTableSolicitud/gestionDataTableSolicitud.php';
          //Comisión
          $urlComision = '../../comisiones/v_comision.php';
          $comisionVendedor = '../../crud/ComisionesVendedores/ComisionesVendedores.php';
          $urlPorcentajes = '../../crud/Porcentajes/gestionPorcentajes.php';
          //Consulta
          $urlClientes = '../../crud/cliente/gestionCliente.php';
          $urlVentas = '../../crud/Venta/gestionVenta.php';
          $urlArticulos = '../../crud/articulo/gestionArticulo.php';
          $urlObjetos = '../../crud/DataTableObjeto/gestionDataTableObjeto.php';
          $urlBitacoraSistema = '../../crud/bitacora/gestionBitacora.php';
          //Mantenimiento
          $urlUsuarios = '../../crud/usuario/gestionUsuario.php';
          $urlCarteraCliente = '../../crud/carteraCliente/gestionCarteraClientes.php';
          $urlPreguntas = '../../crud/pregunta/gestionPregunta.php';
          $urlParametros = '../../crud/parametro/gestionParametro.php';
          $urlPermisos = '../../crud/permiso/gestionPermisos.php';
          $urlRoles = '../../crud/rol/gestionRol.php';
          $urlServiciosTecnicos = '../../crud/TipoServicio/gestionTipoServicio.php';
          $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
          $urlPerfilUsuario='../../crud/PerfilUsuario/gestionPerfilUsuario.php';
          $urlPerfilContraseniaUsuarios='../../crud/PerfilUsuario/gestionPerfilContrasenia.php';
          require_once '../../layout/sidebar.php';
        ?>
      </div>

      <div class="conteiner-main">
            <!-- Encabezado -->
          <div class= "encabezado">
            <div class="navbar-conteiner">
                <!-- Aqui va la barra -->
                <?php include_once '../../layout/navbar.php'?>                             
            </div>        
            <div class ="titulo">
              <H2 class="title-dashboard-task" id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionCotizacion.php');?>">Ver Cotizaciones</H2>
            </div>  
          </div>

        <div class="table-conteiner">
        <div>
            <!-- <a href="../../../TCPDF/examples/reporteCotizacion.php" target="_blank" class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a>  -->
            <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar PDF</button>
          </div>
          <table class="table" id="table-Cotizacion">
            <thead>
              <tr>
                <th scope="col"> N° </th>
                <th scope="col"> CREADO POR </th>
                <th scope="col"> CLIENTE </th>
                <th scope="col"> SUB TOTAL </th>
                <th scope="col"> ISV % </th>
                <th scope="col"> TOTAL </th>
                <th scope="col"> ESTADO </th>
                <th scope="col"> ACCION </th>
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
        ?>
        <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
        <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="../../../Recursos/js/rendimiento/cotizacion/dataTableCotizacion.js" type="module"></script>
        <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
        <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
        <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
</body>

</html>