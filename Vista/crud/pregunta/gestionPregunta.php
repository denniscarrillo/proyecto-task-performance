<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Pregunta.php");
require_once("../../../Controlador/ControladorPregunta.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionPregunta.php');
  (!($_SESSION['usuario'] == 'SUPERADMIN'))
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
    $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ==================== Evento intento de ingreso sin permiso a mantenimiento pregunta. ==========================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionPregunta.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso al mantenimiento de pregunta';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  }else{
    if(isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])){
      /* ====================== Evento salir. ================================================*/
      $accion = ControladorBitacora::accion_Evento();
      $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Exit'];
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de '.$_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    }
    /* ====================== Evento ingreso a mantenimiento pregunta. ========================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionPregunta.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó al mantenimiento de pregunta';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionPregunta.php';
    $_SESSION['descripcionObjeto'] = 'mantenimiento de pregunta';
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
  <title> Pregunta </title>
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
          $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
          $urlPreguntas = './gestionPregunta.php';
          $urlParametros = '../parametro/gestionParametro.php';
          $urlPermisos = '../permiso/gestionPermisos.php';
          $urlRoles = '../rol/gestionRol.php';
          $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
          $urlImg = '../../../Recursos/' . ControladorParametro::obtenerUrlLogo();
          $urlPerfilUsuario='../PerfilUsuario/gestionPerfilUsuario.php';
          $urlPerfilContraseniaUsuarios='../PerfilUsuario/gestionPerfilContrasenia.php';
          $urlRazonSocial = '../razonSocial/gestionRazonSocial.php';
          $urlRubroComercial = '../rubroComercial/gestionRubroComercial.php';
          require_once '../../layout/sidebar.php';
        ?>
      </div>

      <div class="conteiner-main">
        <!-- Encabezado -->
        <div class="encabezado">
          <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../../layout/navbar.php'?>
          </div>
          <div class="titulo">
            <H2 class="title-dashboard-task"
              id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionPregunta.php');?>">Gestión de Preguntas</H2>
          </div>
        </div>

        <div class="table-conteiner">
          <div>
            <a href="#" class="btn_nuevoRegistro btn btn-primary hidden" id="btn_nuevoRegistro" data-bs-toggle="modal"
              data-bs-target="#modalNuevaPregunta"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
            <!-- <a href="../../../TCPDF/examples/reportePreguntas.php" target="_blank" class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a>  -->
            <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
              PDF</button>
          </div>
          <table class="display nowrap table" id="table-Pregunta" style="width:100%">
            <thead>
              <tr>
                <th scope="col"> N° </th>
                <th scope="col"> PREGUNTA </th>
                <th scope="col"> ESTADO </th>
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
        require('modalNuevaPregunta.html');
        require('modalEditarPregunta.html');
        ?>
 <script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <!-- script propios -->
  <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
  <script src="../../../Recursos/js/pregunta/validacionesModalNuevaPregunta.js" type="module"></script>
  <script src="../../../Recursos/js/pregunta/validacionesModalEditarPregunta.js" type="module"></script>
  <script src="../../../Recursos/js/pregunta/dataTablePregunta.js" type="module"></script>
</body>

</html>