<?php
session_start(); //Reanudamos la sesion
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');
require_once("actualizarPerfilContrasenia.php");

if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionUsuario.php');
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
  /* ====================== Evento ingreso a mantenimiento usuario. ========================*/
  $accion = ControladorBitacora::accion_Evento();
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('GESTIONPERFILCONTRASENIA.PHP');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a configurar su nueva contraseña';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  $_SESSION['objetoAnterior'] = 'GESTIONPERFILCONTRASENIA.PHP';
  $_SESSION['descripcionObjeto'] = 'configurar su nueva contraseña';
  /* =======================================================================================*/
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/6266/6266866.png">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- DataTables -->
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Estilos personalizados -->
  <link href="../../../Recursos/css/gestionPerfilContrasenia.css" rel="stylesheet" />
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <title> Actualizar Perfil</title>
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
        $urlPreguntas = '../pregunta/gestionPregunta.php';
        $urlParametros = '../parametro/gestionParametro.php';
        $urlPermisos = '../permiso/gestionPermisos.php';
        $urlRoles = '../rol/gestionRol.php';
        $urlPorcentajes = '../Porcentajes/gestionPorcentajes.php';
        $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
        $urlPerfilUsuario = '../PerfilUsuario/gestionPerfilUsuario.php';
        $urlPerfilContraseniaUsuarios = '../PerfilUsuario/gestionPerfilContrasenia.php';
        $urlEditarCamposPerfil = '../PerfilUsuario/EditarCamposPerfilUsuario.php';
        $urlImg = '../../../Recursos/' . ControladorParametro::obtenerUrlLogo();
        $urlRazonSocial = '../razonSocial/gestionRazonSocial.php';
        $urlRubroComercial = '../rubroComercial/gestionRubroComercial.php';
        require_once '../../layout/sidebar.php';
        ?>
      </div>
      <div class="conteiner-main">
        <div class="navbar-conteiner">
          <!-- Aqui va la barra -->
          <?php include_once '../../layout/navbar.php' ?>
        </div>
        <!-- Cuerpo de la pagina -->
        <div class="container">
          <div class="title-form">
            <div class="img-content">
              <img class="img" src="https://cdn-icons-png.flaticon.com/128/6266/6266866.png" height="50px">
            </div>
            <h2 class="text-title-form">Configura tu nueva contraseña</h2>
          </div>
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formContrasenia">
            <div class="grupo-form">
              <div class="mb-3">
                <input type="password" class="form-control" name="password" id="password" maxlength="15"
                  placeholder="Contraseña Actual">
                <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="newPassword" maxlength="15" name="newPassword"
                  placeholder="Nueva Contraseña">
                <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="confirmPassword" maxlength="15" name="confirmPassword"
                  placeholder="Confirmar Contraseña">
                <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                <input type="checkbox" id="checkbox"> Mostrar Contraseñas
              </div>
              <div class="btn-guardar">
                <a href="../../index.php"><button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" name="submit" href="../PerfilUsuario/gestionPerfilUsuario.php"
                    class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
              </div>
              <?php
              if (!empty($mensaje)) {
                echo '<h2 class="mensaje-error" style="margin-top: 8px;">' . $mensaje . '</h2>';
              }
              ?>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="../../../Recursos/js/librerias/Kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <!-- Scripts propios -->

  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
  <script src="../../../Recursos/js/PerfilUsuario/validacionesPerfilContrasenia.js" type="module"></script>
</body>

</html>