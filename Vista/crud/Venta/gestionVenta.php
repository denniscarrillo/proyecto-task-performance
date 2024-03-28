<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Venta.php");
require_once("../../../Controlador/ControladorVenta.php");
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
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionVenta.php');
  (!($_SESSION['usuario'] == 'SUPERADMIN'))
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
    $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ====================== Evento intento de ingreso sin permiso a  vista de ventas. ============================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionVenta.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a vista de ventas';
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
    /* ====================== Evento ingreso a vista de ventas. =============================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionVenta.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a vista de ventas';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionVenta.php';
    $_SESSION['descripcionObjeto'] = 'vista de ventas';
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
  <link href="../../../Recursos/css/gestionVenta.css" rel="stylesheet" />
  <link href="../../../Recursos/css/gestionUsuario.css" rel="stylesheet" />
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <title> Ventas </title>
</head>

<body style="overflow: hidden;">
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
        $urlVentas = './gestionVenta.php';
        $urlArticulos = '../articulo/gestionArticulo.php';
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
        $urlPerfilUsuarios='../PerfilUsuario/gestionPerfilUsuario.php';
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
              id="<?php echo ControladorBitacora::obtenerIdObjeto('GESTIONVENTA.PHP');?>">Ventas</H2>
          </div>
        </div>
        <div class="table-conteiner">
          <div class="text-left mb-2">
            <a href="#" class="btn_nuevoRegistro btn btn-primary hidden" id="btn_nuevoRegistro" data-bs-toggle="modal"
              data-bs-target="#modalNuevaVenta"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
            <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
              PDF</button>
          </div>
          <table class="display nowrap table" id="table-Ventas" style="width:100%">
            <thead>
              <tr>
                <th scope="col"> No. FACTURA </th>
                <th scope="col"> NOMBRE CLIENTE </th>
                <th scope="col"> RTN/DNI</th>
                <th scope="col"> TOTAL VENTA </th>
                <th scope="col"> CREADO POR </th>
                <th scope="col"> FECHA CREACIÓN </th>
                <th scope="col"> ACCIONES </th>
              </tr>
            </thead>
            <div class="text-left mb-2">
              <button class="btn_Pdf btn btn-primary hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
                PDF</button>
            </div>
            <tbody class="table-group-divider">
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php
      require('modalNuevaVenta.html');
    ?>
  </div>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script> -->
  <script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <!-- Scripts propios -->
  <script src="../../../Recursos/js/Ventas/datatable.js" type="module"></script>
  <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
  <script src="../../../Recursos/js/Ventas/validacionesNuevaVenta.js" type="module"></script>
</body>

</html>