<?php
session_start(); //Reanudamos sesion
require_once('../../../db/Conexion.php');
require_once('../../../Modelo/Bitacora.php');
require_once('../../../Modelo/Tarea.php');
require_once('../../../Controlador/ControladorBitacora.php');
require_once('../../../Controlador/ControladorTarea.php');
require_once('../../../Modelo/Parametro.php');
require_once('../../../Controlador/ControladorParametro.php');

$datosCotizacion = ControladorTarea::obtenerDatos(intval($_GET['idTarea']), $_GET['estadoCliente']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nueva cotización</title>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/6889/6889345.png">
  <!-- Hojas de estilos externas -->
  <link rel="stylesheet" href="../../../Recursos/bootstrap5/bootstrap.min.css">
  <link rel="stylesheet" href="../../../Recursos/bootstrap5/bootstrap.min.css">
  <!-- Hojas de estilos personalizadas -->
  <link rel='stylesheet' href='../../../Recursos/css/layout/estilosEstructura.css'>
  <link rel='stylesheet' href="../../../Recursos/css/layout/sidebar.css">
  <link rel='stylesheet' href='../../../Recursos/css/layout/navbar.css'>
  <link rel='stylesheet' href='../../../Recursos/css/cotizacion/v_cotizacion.css'>
</head>

<body style="overflow: hidden;">
  <!-- Sidebar -->
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
      //Consulta
      $urlClientes = '../../crud/cliente/gestionCliente.php';
      $urlVentas = '../../crud/Venta/gestionVenta.php';
      $urlArticulos = '../../crud/articulo/gestionArticulo.php';
      $urlObjetos = '../../crud/DataTableObjeto/gestionDataTableObjeto.php';
      $urlBitacoraSistema = '../../crud/bitacora/gestionBitacora.php';
      //Mantenimiento
      $urlUsuarios = '../../crud/usuario/gestionUsuario.php';
      $urlEstadoUsuario = '../../crud/estadoUsuario/gestionEstadoUsuario.php';
      $urlCarteraCliente = '../../crud/carteraCliente/gestionCarteraClientes.php';
      $urlPreguntas = '../../crud/pregunta/gestionPregunta.php';
      $urlParametros = '../../crud/parametro/gestionParametro.php';
      $urlPermisos = '../../crud/permiso/gestionPermisos.php';
      $urlRoles = '../../crud/rol/gestionRol.php';
      $urlPorcentajes = '../../crud/Porcentajes/gestionPorcentajes.php';
      $urlServiciosTecnicos = '../../crud/TipoServicio/gestionTipoServicio.php';
      $urlPerfilUsuarios = '../../crud/PerfilUsuario/gestionPerfilUsuario.php';
      $urlPerfilContraseniaUsuarios = '../../crud/PerfilUsuario/gestionPerfilContrasenia.php';
      $urlImg = '../../../Recursos/' . ControladorParametro::obtenerUrlLogo();
      $urlRazonSocial = '../../crud/razonSocial/gestionRazonSocial.php';
      $urlRubroComercial = '../../crud/rubroComercial/gestionRubroComercial.php';
      require_once '../../layout/sidebar.php';
      ?>
    </div>
    <div class="conteiner-main">
      <div class="navbar-conteiner">
        <!-- Aqui va la barra -->
        <?php include_once '../../layout/navbar.php'; ?>
      </div>
      <!-- Cuerpo de la pagina -->
      <main class="main">
        <div class="container-cotizacion">
          <div class="encabezado" id="<?php echo $_GET['idTarea'] ?>">
            <h2 class="title-dashboard-task" id="<?php echo ControladorBitacora::obtenerIdObjeto('v_tarea.php'); ?>"
              name='v_tarea.php'>
              Nueva Cotización</h2>
            <label id="id-cot-tarea" hidden>
              <?php echo ControladorTarea::obtenerIdCotizacionTarea($_GET['idTarea']); ?>
            </label>
          </div>
          <div class="datos-cotizacion" id="<?php echo $_GET['estadoCliente'] ?>">
            <div class="colum-horizontal">

              <div id="input-fecha">
                <label for="fecha" class="form-label bold" id="label-fecha">Fecha: </label>
                <label for="fecha" class="form-label" id="fecha">
                  <?php date_default_timezone_set('America/Tegucigalpa');
                  setlocale(LC_TIME, "Spanish_Honduras");
                  echo date('l jS \of F Y h:i:s A'); ?>
                </label>
                <p class="mensaje"></p>
              </div>
            </div>
            <div class="mb-3" id="input-cotizacion">
              <label for="n-cotizacion" class="form-label bold" id="label-correo">RTN/DNI:</label>
              <label for="n-cotizacion" class="form-label" id="nombre-cliente">
                <?php echo $datosCotizacion['RTN'] ?>
              </label>
            </div>
            <div class="mb-3" id="input-cotizacion">
              <label for="n-cotizacion" class="form-label bold" id="label-correo">Cliente:</label>
              <label for="n-cotizacion" class="form-label" id="nombre-cliente">
                <?php echo $datosCotizacion['NOMBRE'] ?>
              </label>
            </div>
            <div class="mb-3" id="input-telefono">
              <label for="telefono" class="form-label bold" id="label-correo">Teléfono:</label>
              <label for="validez" class="form-label" id="correo-cliente">
                <?php echo $datosCotizacion['TELEFONO'] ?>
              </label>
            </div>
            <div class="mb-3" id="input-vendedor">
              <label for="vendedor" class="form-label bold" id="label-title-vendedor">Vendedor:</label>
              <label for="validez" class="form-label" id="nombre-vendedor">
                <?php echo $datosCotizacion['VENDEDOR'] ?>
              </label>
            </div>
            <div class="mb-3" id="input-validez">
              <label for="validez" class="form-label bold" id="label-correo">Válidez:</label>
              <label for="validez" class="form-label" id="validez-cotizacion">
                <?php echo $datosCotizacion['vigencia'] . ' dias' ?>
              </label>
              <p class="mensaje"></p>
            </div>
            <label class="mb-3 form-label bold label-estado-cot exist hidden">Estado: </label><label
              class="estado-cot exist hidden" id="estado-cot"></label>
            <div class="container-desc bold new hidden">
              <label class="form-label ">Descuento:</label>
              <select title="Estado descuento" class="form-select" id="estado-desc" disabled>
                <option selected>No aplica</option>
                <option>Aplica</option>
              </select>
              <div class="container-input-cant-desc"></div>
            </div>
          </div>
          <div class="container-btns-cotizacion">
            <a href="#" class="btn_nuevoRegistro btn btn-primary exist hidden" id="btn-nueva-cot"><i
                class="fa-solid fa-circle-plus"></i> Nueva Cotización</a>
            <!-- <button id="btn-anular-cot" class="btn btn-primary">Nueva cotización</button> -->
            <!-- <a href="../../../TCPDF/examples/reporteCotizacion.php" target="_blank" class="btn_Pdf btn btn-primary exist hidden" id="btn_Pdf"><i class="fas fa-file-pdf"> </i> Generar PDF</a> -->
            <button class="btn_Pdf btn btn-primary exist hidden" id="btn_Pdf"> <i class="fas fa-file-pdf"></i> Generar
              PDF</button>
          </div>
          <form id="form-cotizacion" accion="">
            <div class="productos-cotizacion">
              <div class="nuevo-producto">
                <button type="button" class="btn btn-primary new hidden" data-bs-toggle="modal"
                  data-bs-target="#modalProductosCotizados" id="btn-productos">
                  <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
                  Seleccionar artículos...
                </button>
                <!-- <div class="data-container">
                  <input type="text" name="descripcion" id="descripcion" class="fila-producto new hidden"
                    placeholder="Descripción">
                  <p class="mensaje"></p>
                </div>
                <div class="data-container">
                  <input type="text" name="marca" id="marca" class="fila-producto new hidden" placeholder="Marca">
                  <p class="mensaje"></p>
                </div>
                <div class="data-container">
                 <input type="number" name="precio" id="precio" class="fila-producto new hidden" placeholder="Precio" min="1" oninput="validarPrecio(event)">
                 <p class="mensaje"></p>
                </div> -->
                <!-- <button type="button" class="btn-agregar-producto new hidden" id="btn-agregar-producto"><i
                    class="fa-solid fa-plus"></i> Producto
                </button> -->
                <!-- <input type="number" name="cantidad" id="cantidad" class="fila-producto" placeholder="Cantidad"> -->
                <div id="button-container"></div>
              </div>
              <table id="productos-cotizacion" class="table table-hover">
                <thead>
                  <tr>
                    <th class="th-col-row">ITEM</th>
                    <th class="th-col-row">DESCRIPCIÓN</th>
                    <th class="th-col-row">MARCA</th>
                    <th class="th-col-row">CANTIDAD</th>
                    <th class="th-col-row">PRECIO</th>
                    <th class="th-col-row">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="t-body">
                  <tr id="row-temp">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              <div class="resumen-cotizacion">
                <div class="inputs">
                  <div class="align-in-column" id="input-sub-total">
                    <label for="sub-total" class=" bold" id="label-correo">SubTotal</label>
                    <label name="sub-total" class="align-end" id="sub-total">Lps. 0.00</label>
                  </div>
                  <div class="align-in-column hidden" id="input-descuento">
                    <label for="descuento" class="bold" id="label-correo">Descuento</label>
                    <label name="descuento" class="align-end" id="descuento">Lps. 0.00</label>
                  </div>
                  <div class="align-in-column hidden" id="input-sub-descuento">
                    <label for="sub-descuento" class="bold" id="label-correo">Sub Descuento</label>
                    <label name="sub-descuento" class="align-end" id="sub-descuento">Lps.
                      0.00</label>
                  </div>
                  <div class="align-in-column" id="input-impuesto">
                    <label for="impuesto" class="bold" id="label-correo">15% I.S.V</label>
                    <label name="impuesto" class="align-end" id="impuesto">Lps. 0.00</label>
                  </div>
                  <div class="align-in-column" id="input-total">
                    <label for="total" class="bold" id="label-correo">Total</label>
                    <label name="total" class="align-end" id="total">Lps. 0.00</label>
                  </div>
                </div>
              </div>
            </div>
            <a href="../v_tarea.php" class="btn-primary btn-salir-cotizacion" id="btn-salir-cotizacion">
              <i class="fa-solid fa-chevron-left"></i>
              <label> Regresar a tareas</label>
            </a>
            <button type="submit" id="btn-submit-cotizacion" class="new hidden">Guardar</button>
          </form>
        </div>
      </main>
    </div>
    <?php
    require_once('modalProductosCotizados.html');
    ?>
  </div>
  <script src="../../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/dataTables.bootstrap5.min.js"></script>
  <script src="../../../Recursos/js/librerias/SweetAlert2.all.min.js"></script>
  <script src="../../../Recursos/js/rendimiento/cotizacion/validacionesCotizacion.js" type="module"></script>
  <script src="../../../Recursos/js/rendimiento/cotizacion/v_cotizacion.js" type="module"></script>
</body>

</html>