<?php
require_once("../../../db/Conexion.php");
require_once('../../../Modelo/Usuario.php');
require_once("../../../Modelo/Bitacora.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Modelo/BackupRestore.php');
require_once('../../../Controlador/ControladorUsuario.php');
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Controlador/ControladorParametro.php');
require_once('../../../Controlador/ControladorBackupRestore.php');

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('GESTIONBACKUPRESTORE.PHP');
  //Se valida el usuario, si es SUPERADMIN por defecto tiene permiso caso contrario se valida el permiso vrs base de datos
  (!($_SESSION['usuario'] == 'SUPERADMIN')) 
  ? $permisoConsulta = ControladorUsuario::permisoConsultaRol($idRolUsuario, $idObjetoActual) 
  : 
    $permisoConsulta = true;
  ;
  if(!$permisoConsulta){
    /* ====================== Evento intento de ingreso sin permiso a vista de backup y restore. ======================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('GESTIONBACKUPRESTORE.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a la vista de backup y restore de base de datos';
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
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de la '.$_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    }
    /* ==================================== Evento ingreso . =================================*/
    $accion = ControladorBitacora::accion_Evento();
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('GESTIONBACKUPRESTORE.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a la vista de backup y restore de base de datos';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'GESTIONBACKUPRESTORE.PHP';
    $_SESSION['descripcionObjeto'] = 'vista de backup y restore de base de datos';
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
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <link rel="stylesheet" href="../../../Recursos/css/gestionBackupRestore.css">

  <title>Backup & Restore</title>
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
          $urlRestoreBackup = '../backupAndRestore/gestionBackupRestore.php';
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
            id="<?php echo ControladorBitacora::obtenerIdObjeto('GESTIONBACKUPRESTORE.PHP');?>" name='GESTIONBACKUPRESTORE.PHP'>Backup y Restore de la base de datos del sistema</H2>
        </div>
      </div>
      <div class="container-backup-restore">
        <div class="container-backup">
            <h2>Crear un punto de restauración</h2>
              <div class="containter-text-dbName">
                <span class="db-name-label">Base de datos: <span class="db-name">RENDIMIENTO_TAREAS</span></span>
              </div>
              <div class="button-container">
                  <button type="button" id="btn-backup" class="btn-backup btn btn-primary btn-backRestore hidden">Respaldar</button>
              </div>
          </div>
          <div class="container-restore">
            <h2>Restaurar base de datos</h2>
            <form action="./generarRestore.php" method="post" id="form-historial-backups">
                <select name="historial-backups" id="historial-backups" class="form-control">
                  <option value="">Seleccionar punto de restauración...</option>
                </select>
                <div class="button-container">
                  <button type="button" id="btn-restore" class="btn-restore btn btn-primary btn-backRestore hidden">Restaurar</button>
                </div>
            </form>
          </div>
      </div>

    </div>
  </div>
  </div>
<script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/backupAndRestore/Backup.js"></script>
  <script src="../../../Recursos/js/permiso/validacionPermisoInsertar.js"></script>
</body>
</html>