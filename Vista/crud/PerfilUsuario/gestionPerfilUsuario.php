<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//Reanudamos la sesion
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once("../../../Modelo/Pregunta.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');
require_once("../../../Controlador/ControladorPregunta.php");
require_once("obtenerContraseniaPerfil.php");

$datos = ControladorUsuario::obtenerDatosPerfilUsuario($_SESSION['usuario']);
$preguntas = ControladorPregunta::obtenerPreguntasXusuario($_SESSION['usuario']);

if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionPerfilUsuario.php');
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
  date_default_timezone_set('America/Tegucigalpa');
  $newBitacora->fecha = date("Y-m-d h:i:s");
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('GESTIONPERFILUSUARIO.PHP');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a su perfil de usuario';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  $_SESSION['objetoAnterior'] = 'GESTIONPERFILUSUARIO.PHP';
  $_SESSION['descripcionObjeto'] = 'su perfil de usuario';
  /* =======================================================================================*/
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7563/7563276.png">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- DataTables -->
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Estilos personalizados -->
  <link href="../../../Recursos/css/gestionPerfilUsuario.css" rel="stylesheet" />
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <title>Perfil de usuario</title>
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
        <div class="navbar-conteiner">
          <!-- Aqui va la barra -->
          <?php include_once '../../layout/navbar.php' ?>
        </div>
        <!-- Cuerpo de la pagina -->
        <div class="container">
          <div class="title-form">
            <div class="img-content">
              <img class="img" src="https://cdn-icons-png.flaticon.com/128/7563/7563276.png" height="50px">
            </div>
            <h2 class="text-title-form">Datos Del Usuario</h2>
          </div>
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="form-Edit-DatosPerfil">
          <div class="btn-editar">
              <a href="../PerfilUsuario/modalConfirmarContrasenia.php" class="btn btn-secondary">
                  <i class="fa-solid fa-pen-to-square"></i>Editar Perfil
              </a>
           </div>

            <div class="grupo-form1">
              <div class="mb-3">
                <label class="titulos">Usuario:</label>
                <label>
                  <?php echo $_SESSION['usuario'] ?>
                </label>
              </div>
              <div class="mb-3">
                <label class="titulos" for="nombre">Nombre:</label>
                <label>
                  <?php echo $datos['nombre'] ?>
                </label>
              </div>
              <div class="mb-3">
                <label class="titulos" for="rol">Rol:</label>
                <label>
                  <?php echo $datos['rol_name'] ?>
                </label>
              </div>
              <div class="mb-3">
                <label class="titulos" for="rtn">RTN:</label>
                <label>
                  <?php echo $datos['rtn'] ?>
                </label>
              </div>
              <div class="mb-3">
                <label class="titulos" for="telefono">Teléfono:</label>
                <label>
                  <?php echo $datos['telefono'] ?>
                </label>
              </div>
              <div class="mb-3">
                <label class="titulos" for="direccion">Dirección:</label>
                <label>
                  <?php echo $datos['direccion'] ?>
                </label>
              </div>
            </div>
            <div class="grupo-form">
              <div class="mb-3">
                <label class="titulos" for="email">Correo Electrónico:</label>
                <label>
                  <?php echo $datos['correo'] ?>
                </label>

              </div>
              <div class="mb-3">
                <label class="titulos" for="pregunta">Preguntas:</label>
                <?php
                foreach ($preguntas as $pregunta) {
                  $valorPregunta= isset($pregunta['preguntas']) ? : '';
                  ?>
                  <label>
                    <?php echo $pregunta['preguntas']; ?>
                  </label><br><br>
                  <?php
                }
                ?>
              </div>

            </div>
            <!-- Footer -->

        </div>
      </div>
    </div>
  </div>
  <script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/Sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <!-- Scripts propios -->
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script> 
</body>

</html>