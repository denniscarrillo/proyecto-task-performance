<?php
require_once('validacionesComision.php');
require_once('obtenerEstadoComision.php');
require_once('../../Modelo/Parametro.php');
require_once('../../Controlador/ControladorParametro.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Nueva comision</title>
  <!-- Boostrap5 -->
  <link rel="stylesheet" href="../../Recursos/bootstrap5/bootstrap.min.css">
  <link href="../../Recursos/bootstrap5/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../Recursos/css/v_nuevaComision.css" rel="stylesheet">
  <link href='../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../Recursos/css/layout/footer.css' rel='stylesheet'>
</head>

<body style="overflow: hidden;">

  <div class="conteiner-global">
    <!-- row gx-0 row-conteiner -->
    <div class="sidebar-conteiner">
      <?php
      $urlIndex = '../index.php';
      // Rendimiento
      $urlMisTareas = '../rendimiento/v_tarea.php';
      $urlCotizacion = '../rendimiento/cotizacion/gestionCotizacion.php';
      $urlConsultarTareas = '../crud/DataTableTarea/gestionDataTableTarea.php';
      $urlMetricas = '../crud/Metricas/gestionMetricas.php';
      $urlEstadisticas = '../grafica/estadistica.php';
      //Solicitud
      $urlSolicitud = '../crud/DataTableSolicitud/gestionDataTableSolicitud.php';
      //Comisión
      $urlComision = './v_comision.php';
      $comisionVendedor = '../crud/ComisionesVendedores/ComisionesVendedores.php';
      $urlPorcentajes = '../crud/Porcentajes/gestionPorcentajes.php';
      //Consulta
      $urlClientes = '../crud/cliente/gestionCliente.php';
      $urlVentas = '../crud/Venta/gestionVenta.php';
      $urlArticulos = '../crud/articulo/gestionArticulo.php';
      $urlObjetos = '../crud/DataTableObjeto/gestionDataTableObjeto.php';
      $urlBitacoraSistema = '../crud/bitacora/gestionBitacora.php';
      //Mantenimiento
      $urlUsuarios = '../crud/usuario/gestionUsuario.php';
      $urlEstadoUsuario = '../crud/estadoUsuario/gestionEstadoUsuario.php';
      $urlCarteraCliente = '../crud/carteraCliente/gestionCarteraClientes.php';
      $urlPreguntas = '../crud/pregunta/gestionPregunta.php';
      $urlParametros = '../crud/parametro/gestionParametro.php';
      $urlPermisos = '../crud/permiso/gestionPermisos.php';
      $urlRoles = '../crud/rol/gestionRol.php';
      $urlServiciosTecnicos = '../crud/TipoServicio/gestionTipoServicio.php';
      $urlPerfilUsuario = '../PerfilUsuario/gestionPerfilUsuario.php';
      $urlPerfilContraseniaUsuarios = '../PerfilUsuario/gestionPerfilContrasenia.php';
      $urlImg = '../../Recursos/' . ControladorParametro::obtenerUrlLogo();
      $urlRazonSocial = '../crud/RazonSocial/gestionRazonSocial.php';
      $urlRubroComercial = '../crud/rubroComercial/gestionRubroComercial.php';
      $urlRestoreBackup = '../crud/backupAndRestore/gestionBackupRestore.php';
      require_once '../layout/sidebar.php';
      ?>
    </div>

    <div class="conteiner-main">
      <!-- Encabezado -->
      <div class="encabezado">
        <div class="navbar-conteiner">
          <!-- Aqui va la barra -->
          <?php include_once '../layout/navbar.php' ?>
        </div>
      </div>

      <div class="col-10 form-conteiner">
        <form action="" method="post" id="form-Comision">
          <div class="title-form">
            <div class="img-content">
              <img class="img" src="https://cdn-icons-png.flaticon.com/512/2953/2953536.png" height="50px">
            </div>
            <h2 class="text-title-form">Nueva comisión</h2>
          </div>
          <div class="form-element">
            <label>Fecha de ingreso</label>
            <input type="text" class="form-control" id="fecha-comision">
          </div>
          <!-- <div class="form-element">
            <label>ID comision</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="conteiner-id-venta form-element">
            <label>Venta N°</label>
            <input type=" text" class="form-control" id="id-venta">
            <button type="button" class="btn-call-modal btn btn-primary" data-bs-toggle="modal"
              data-bs-target="#modalfiltroVenta">
              Seleccionar...
            </button>
          </div>
          <div class="form-element">
            <label>Estado Comision:</label>
            <label id="mensaje-estado"></label>
            <p class="mensaje" id="mensaje"></p>
          </div>

          <div class="form-element">
            <label>Monto</label>
            <input type="text" class="form-control" id="monto-total">
          </div>
          <div class="form-element">
            <label>Porcentaje</label>
            <label id="mensaje-tipo-cliente"></label>
            <select name="porcentajeComision" class="form-control" id="porcentaje-comision">
              <option value="0">Seleccionar...</option>
              <?php
              foreach ($porcentajes as $porcentaje) {
                // Formatear el porcentaje sin decimales y con el símbolo de porcentaje
                $porcentajeFormateado = number_format($porcentaje['porcentaje'] * 100, 0) . '%';
                $opcion = '<option value="' . $porcentaje['idPorcentaje'] . '">' . $porcentajeFormateado . ' - ' . $porcentaje['descripcion'] . '</option>';
                echo $opcion;
              }
              ?>
            </select>
          </div>
          <div class="form-element">
            <label>Comisión venta</label>
            <input type="text" class="form-control" id="comision-total">
          </div>
          <!-- <div class="form-element">
            <label>Fecha de liquidación</label>
            <input type="text" class="form-control" id="fecha_V" value=""> -->
          <div class="form-element">
            <label>Vendedores:</label>
            <div class="conteiner-vendedores" id="conteiner-vendedores">
            </div>
          </div>
          <div class="form-element-btns">
            <button type="submit" class="btn btn-primary" id="btn-guardar-comision">Guardar</button>
            <button type="button" class="btn btn-secondary" id="btn-cancelar">Cancelar</button>
          </div>
        </form>
      </div>
      <!-- Footer -->
      <!-- <div class="footer-conteiner"> -->
    </div>
  </div>
  </div>
  <?php
  require_once 'modalFiltroVenta.html';
  require_once 'modalVentas.html';
  ?>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="../../Recursos/js/comision/validacionesComision.js"></script>
  <script src="../../Recursos/js/index.js"></script>
</body>

</html>