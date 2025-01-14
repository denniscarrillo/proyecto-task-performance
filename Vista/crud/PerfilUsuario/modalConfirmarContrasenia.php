

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}//Reanudamos la sesion
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');
require_once("ObtenerContraseniaPerfil.php");


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
  <link href="../../../Recursos/css/modalConfirmarContrasenia.css" rel="stylesheet" />
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
              <img class="img" src="https://cdn-icons-png.flaticon.com/128/6266/6266866.png" height="50px">
            </div>
            <h1 class="modal-title fs-5" id="editarModalLabel">Confirmar Contraseña</h1>
          </div>
          <div style="display: flex; justify-content: center;">
    <img class="img" src="https://cdn-icons-png.flaticon.com/128/11530/11530802.png" height="80px">
</div>
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formPerfilContrasenia">
            <div class="grupo-form">
              <div class="mb-3">
                <input type="password" class="form-control" id="confirmPassword" maxlength="15" name="confirmPassword" placeholder="Confirmar Contraseña">
                <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                <input type="checkbox" id="checkbox"> Mostrar Contraseñas
              </div>
             <div class="btn-guardar">
             <a href="../PerfilUsuario/gestionPerfilUsuario.php" class="btn btn-secondary btn-cancel">Cancelar</a>
                        <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
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
  <script src="../../../Recursos/js/PerfilUsuario/validacionesModalConfirmarContrasenia.js" type="module"></script>
</body>

</html>
