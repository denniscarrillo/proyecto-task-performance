<?php
session_start(); //Reanudamos la sesion
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/DataTableSolicitud.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorDataTableSolicitud.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Usuario.php');
require_once('../../../Controlador/ControladorUsuario.php');
require_once('../../../Modelo/Tarea.php');
require_once('../../../Controlador/ControladorTarea.php');
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');


if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('v_Solicitud.php');
  //Se valida el usuario, si es SUPERADMIN por defecto tiene permiso caso contrario se valida el permiso vrs base de datos
  (!($_SESSION['usuario'] == 'SUPERADMIN')) 
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
  $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ====================== Evento intento de ingreso sin permiso a solicitud. ================================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionSolicitud.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a solicitud';
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
    /* ====================== Evento ingreso a vista solicitud. =====================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionSolicitud.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a vista a la vista de solicitud';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionSolicitud.php';
    $_SESSION['descripcionObjeto'] = 'vista de solicitud';
    /* =======================================================================================*/
  }
} else {
  header('location: ../../login/login.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/3153/3153506.png">
  <!-- DataTables -->
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <link href='../../../Recursos/css/v_nueva_solicitud.css' rel='stylesheet'>
  <!-- Estilos personalizados -->

  <link href="../../../Recursos/css/modalClienteFrecuente.css" rel="stylesheet">
  <!-- <link href="../../../Recursos/css/modalEditarTarea.css" rel="stylesheet"> -->
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <link href="../../../Recursos/css/ModalmenuClientes.css" rel="stylesheet">

  <title>Nueva solicitud</title>
</head>

<body>
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
      <div class="conteiner-main">
        <div class="encabezado">
          <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../../layout/navbar.php' ?>
          </div>
          <div class="titulo">
            <h2 class="title-dashboard-task">Generar nueva solicitud de Servicio</h2>
          </div>
        </div>

        <div class="form-conteiner">
          <div class="form-element">
            <label class="titulo-radios">Tipo de Cliente: </label>
            <div class="radio-conteiner-s">
            <div class="radio-conteiner-existente">
                <input type="radio" name="radioOption" id="clienteExistente" class="radio-solicitud" value="Existente">
                <label for="clienteExistente" class="radio-label-solicitud">Existente</label>
            </div>
            <div class="radio-conteiner-nuevo">
                <input type="radio" name="radioOption" id="clienteNuevo" class="radio-solicitud" value="Nuevo">
                <label for="clienteNuevo" id="radioCliente" class="radio-label-solicitud">Nuevo</label>
            </div>
            </div>
          </div>
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="form-solicitud">

            <div class="group-form">
              <div class="form-element input-conteiner" id="containerFacturacliente">
                <label for="id-factura" class="form-label">N° Factura:</label>
                <input type="text" id="idfactura" name="numeroFactura" class="form-control" readonly>
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner" id="containerrtncliente">
                <label for="rtn-cliente" class="form-label" id="" name="codC">RTN:</label>
                <input type="text" id="rtnCliente" name="rtnCliente" class="form-control">
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner">
                <label for="nombre" class="form-label">Nombre Cliente:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" disabled>
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" disabled>
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner" id="containerCorreocliente">
                <label for="correoL" class="form-label">Correo electrónico Cliente</label>
                <input type="text" id="correoCliente" name="correoElectronico" class="form-control">
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner">
                <label for="correoL" class="form-label">Correo electrónico destinado:</label>
                <input type="text" id="correo" name="correoElectronico" class="form-control" disabled>
                <p class="mensaje"></p>
              </div>
            </div>
            <div class="group-form">
              <div class="form-element input-conteiner">
                <label for="fecha-solicitud" class="form-label">Fecha solicitud:</label>
                <input type="date" id="fechasolicitud" name="fechaSolicitud" class="form-control" disabled>
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner">
                <label for="tipo-servicio" class="form-label">Tipo Servicio: </label>
                <select name="tiposervicio" id="tiposervicio" class="form-control"></select>
                <p class="mensaje"></p>
              </div>

              <div class="form-element input-conteiner">
                <label for="direccion" class="form-label">Ubicación instalación:</label>
                <input type="text" id="direccion" name="ubicacionInstalacion" class="form-control" disabled>
                <p class="mensaje"></p>
              </div>
              <div class="form-element input-conteiner">
                <label for="descripcion" class="form-label">Descripción De Servicios:</label>
                <textarea type="text" id="descripcion" name="descripcion" class="form-control" disabled></textarea>
                <p class="mensaje"></p>
              </div>
            </div>
        </div>
        <div class="table-conteiner">
          <div class="mb-3 conteiner-id-articulo">
            <p class="titulo-articulo">Productos Mantenimiento</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
              data-bs-target="#modalArticulosSolicitud" id="btnarticulos">
              Seleccionar... <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
            </button>
          </div>
          <table id="tablearticulos" class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Artículo</th>
                <th scope="col">Marca</th>
                <th scope="col">Cantidad</th>
                <th scope="col"> Acciones </th>
              </tr>
            </thead>
            <tbody id="listarticulos" class="table-group-divider">
              <!-- Articulos de interes -->
            </tbody>
          </table>
        </div>
        <!-- Botones -->
        <div class="btn-guardar">
          <a href="./gestionDataTableSolicitud.php"><button type="button" id="btncerrar2"
              class="btn btn-secondary">Cancelar</button></a>
          <button type="submit" name="actualizarTarea" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
            Guardar y Enviar</button>
        </div>
        </form>
      </div>
      </main>
    </div>
  </div>
  <?php
  require_once('modalClienteFrecuente.html');
  require_once('modalArticulosSolicitud.html');
  require_once('modalFacturaSolicitud.html');
  require_once('modalMenuClientes.html');
  require_once('modalCarteraCliente.html');
  
?>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <!-- Scripts propios -->
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
  <script src="../../../Recursos/js/DataTableSolicitud/vistaClienteFrecuente.js" type="module"></script>
  <script src="../../../Recursos/js/DataTableSolicitud/validacionesNuevaSolicitud.js" type="module"></script>

</html>