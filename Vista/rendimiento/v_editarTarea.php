<?php
session_start(); //Reanudamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Modelo/Bitacora.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorBitacora.php');
require_once('../../Modelo/Parametro.php');
require_once('../../Controlador/ControladorParametro.php');

$clasificacionLeads = ControladorTarea::obtenerClasificacionLead();
$estadosTarea = ControladorTarea::traerEstadosTarea();
$origenLeads = ControladorTarea::obtenerOrigenLead();
$razonSociales = ControladorTarea::obtenerRazonSocial();
$rubroSociales = ControladorTarea::obtenerRubroComercial();
$estadoTarea = ControladorTarea::obtenerTipoCliente(intval($_GET['idTarea']));
//Valida si tiene sesion
if (!isset($_SESSION['usuario'])) {
	header('location: ../login/login.php');
	die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="../../Recursos/bootstrap5/bootstrap.min.css">
  <!-- Estilos layout -->
  <link rel='stylesheet' href='../../Recursos/css/layout/estilosEstructura.css'>
  <link rel='stylesheet' href='../../Recursos/css/tarea.css'>
  <link rel='stylesheet' href='../../Recursos/css/modalEditarTarea.css'>
  <link rel='stylesheet' href='../../Recursos/css/layout/navbar.css'>
  <link rel='stylesheet' href="../../Recursos/css/layout/sidebar.css">
  <link rel='stylesheet' href="../../Recursos/components/css/sidePanel.css">
  <link rel='stylesheet' href="../../Recursos/css/v_EditarTarea.css">
  <link rel='stylesheet' href="../../Recursos/css/estilosMensajesError.css">
  <title>Editar tarea</title>
</head>

<body style="overflow: hidden;">
  <!-- Sidebar -->
  <div class="conteiner-global">
    <div class="sidebar-conteiner">
      <?php
			$urlIndex = '../index.php';
			// Rendimiento
			$urlMisTareas = './v_tarea.php';
			$urlCotizacion = './cotizacion/gestionCotizacion.php';
			$urlConsultarTareas = '../crud/DataTableTarea/gestionDataTableTarea.php';
			$urlMetricas = '../crud/Metricas/gestionMetricas.php';
			$urlEstadisticas = '../grafica/estadistica.php';
			//Solicitud
			$urlSolicitud = '../crud/DataTableSolicitud/gestionDataTableSolicitud.php';
			//Comisión
			$urlComision = '../comisiones/v_comision.php';
			//Consulta
			$urlClientes = '../crud/cliente/gestionCliente.php';
			$urlVentas = '../crud/Venta/gestionVenta.php';
			$urlArticulos = '../crud/articulo/gestionArticulo.php';
			$urlObjetos = '../crud/DataTableObjeto/gestionDataTableObjeto.php';
			$urlBitacoraSistema = '../crud/bitacora/gestionBitacora.php';
			//Mantenimiento
			$urlUsuarios = '../crud/usuario/gestionUsuario.php';
			$urlCarteraCliente = '../crud/carteraCliente/gestionCarteraClientes.php';
			$urlPreguntas = '../crud/pregunta/gestionPregunta.php';
			$urlParametros = '../crud/parametro/gestionParametro.php';
			$urlPermisos = '../crud/permiso/gestionPermisos.php';
			$urlRoles = '../crud/rol/gestionRol.php';
			$urlPorcentajes = '../crud/Porcentajes/gestionPorcentajes.php';
			$urlServiciosTecnicos = '../crud/TipoServicio/gestionTipoServicio.php';
			$urlPerfilUsuarios = '../crud/PerfilUsuario/gestionPerfilUsuario.php';
			$urlPerfilContraseniaUsuarios = '../crud/PerfilUsuario/gestionPerfilContrasenia.php';
			$urlImg = '../../Recursos/' . ControladorParametro::obtenerUrlLogo();
			$urlRazonSocial = '../crud/razonSocial/gestionRazonSocial.php';
			$urlRubroComercial = '../crud/rubroComercial/gestionRubroComercial.php';
			require_once '../layout/sidebar.php';
			?>
    </div>
    <div class="conteiner-main">
      <div class="navbar-conteiner">
        <!-- Aqui va la barra -->
        <?php include_once '../layout/navbar.php'; ?>
      </div>
      <div class="side-panel-container">
      </div>
      <div class="side-panel-content">
        <div class="title-container">
          <h2 class="title-text tab-selected" id="tab-comment"
            name="<?php echo (isset($_SESSION['usuario'])) ? $_SESSION['usuario'] : ''; ?>">Comentarios</h2>
          <h2 class="title-text" id="tab-history">Historial</h2>
          <button type="button" id="btn-close-comment" class="btn-close" aria-label="Close"></button>
        </div>
        <div id="comment-history-container" class="comments-container">
          <div class="comments-container-list" id="comments-container-list">
            <!-- Aqui van todos los comentarios -->
          </div>
          <div class="history-container" id="history-container">

          </div>
          <form action="" id="form-comentario" class="container-chat">
            <textarea id="input-comentario" class="input-comentario" placeholder="Escribe un comentario..."></textarea>
            <button type="submit" id="btn-guardarComentario" class="btn btn-primary btn-Comentario"><i
                class="fa-solid fa-paper-plane"></i></button>
          </form>
        </div>
      </div>
      <!-- Cuerpo de la pagina -->
      <main class="main">
        <button id="btn-comment" title="Comentarios"><i class="fa-solid fa-comment-dots"></i></button>
        <div class="conteiner-form">
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="form-Edit-Tarea">
            <div class="encabezado-tarea">
              <div class="mb-3">
                <label class="text-cliente">Tipo cliente:</label>
                <label id="tipoCliente" hidden><?php print $estadoTarea ?></label>
                <input type="radio" name="radioOption" id="cliente-existente" class="radio" value="Existente"><label
                  for="cliente-existente" class="radio-label form-label">Existente</label>
                <input type="radio" name="radioOption" id="cliente-nuevo" class="radio" value="Nuevo" checked><label
                  for="cliente-nuevo" class="radio-label form-label">Nuevo</label>
              </div>
              <div class="mb-3 data-container title_container">
                <div class="data-container title_container">
                  <label for="input-titulo-tarea" class="form-label label-title-task">Título de la tarea</label>
                  <input type="text" name="input-titulo-tarea" id="input-titulo-tarea" class="form-control"
                    value="<?php echo ControladorTarea::obtenerEstadoTarea(intval($_GET['idTarea']))['titulo'] ?>">
                  <p class="mensaje"></p>
                </div>
                <button type="button" id="btn-finalizar-tarea">
                  <?php ($estadoTarea == 'FINALIZADA') ? print 'Tarea finalizada' : print '<i class="fa-solid fa-text-slash"></i> Finalizar tarea'; ?>
                </button>
                <label id="estado-finalizacion"
                  hidden><?php echo ControladorTarea::obtenerTareaFinalizada($_GET['idTarea']) ?>
                </label>
              </div>
              <div class="mb-3 data-container">
                <label
                  id="<?php echo ControladorTarea::obtenerEstadoTarea(intval($_GET['idTarea']))['id_estadoAvance'] ?>"
                  class="id-estado-tarea" hidden="true" name="estadoTarea"></label>
                <input type="text" value="<?php echo $_GET['idTarea']; ?>" id="id-Tarea" class="id-tarea" name="idTarea"
                  hidden="true">
                <label for="estados-tarea" class="form-label"> Estado: </label>
                <label id="estado-tarea"></label>
                <select name="estadoTarea" id="estados-tarea" class="form-select">
                  <!-- Opciones estados de tarea -->
                  <?php
									foreach ($estadosTarea as $estado) {
										echo '<option value="' . $estado['idEstado'] . '">' . $estado['estado'] . '</option>';
									}
									?>
                </select>
                <p class="mensaje"></p>
              </div>
            </div>
            <div id="group-inputs">
              <!-- Columna 1 -->
              <div class="grupo-form">
                <div class="mb-3 data-container" id="container-rtn-cliente">
                  <label for="rnt-cliente" class="form-label" name="estadoEdicion" id="true">RTN:</label>
                  <label class="mensaje-rtn"></label>
                  <input type="text" name="rtnCliente" id="rnt-cliente" class="form-control"
                    placeholder="Ingrese el DNI o RTN">
                  <p class="mensaje"></p>
                  <!-- Aqui va el boton del filtro de clientes -->
                </div>
                <div class="mb-3 data-container" id="container-num-factura" hidden>
                  <label for="num-factura" class="form-label">N° FACTURA: </label>
                  <p class="mensaje"></p>
                  <input type="text" name="num-factura" id="num-factura" class="form-control" disabled>
                </div>
                <div class="mb-3 data-container">
                  <label for="nombre" class="form-label">Nombre Cliente:</label>
                  <input type="text" name="nombre" id="nombre-cliente" class="form-control"
                    placeholder="Nombre del cliente">
                  <p class="mensaje"></p>
                </div>
                <div class="mb-3 data-container">
                  <label for="telefono" class="form-label">Teléfono: </label>
                  <input type="text" name="telefono" id="telefono-cliente" class="form-control"
                    placeholder="Número de teléfono">
                  <p class=" mensaje"></p>
                </div>
                <div class="mb-3 data-container" id="container-correo">
                  <label for="correo" class="form-label" id="label-correo">Correo Electrónico: </label>
                  <input type="text" name="correo" id="correo-cliente" class="form-control"
                    placeholder="Correo electrónico">
                  <p class="mensaje"></p>
                </div>
              </div>
              <!-- Columna 2 -->
              <div class="grupo-form">
                <div class="mb-3 data-container">
                  <label for="direccion" class="form-label">Dirección: </label>
                  <input type="text" name="direccion" id="direccion-cliente" class="form-control"
                    placeholder="Dirección principal del cliente">
                  <p class="mensaje"></p>
                </div>
                <div class="mb-3 data-container" id="container-clasificacion-lead" hidden="true">
                  <label for="clasificacionlead" class="form-label">Clasificación Lead: </label>
                  <select id="clasificacion-lead" class="form-select" name="clasificacionLead">
                    <!-- Opciones clasificacion lead -->
                    <option value="" disabled selected>Seleccionar una clasificación...</option>
                    <?php
										foreach ($clasificacionLeads as $clasificacionLead) {
											echo '<option value="' . $clasificacionLead['id'] . '">' . $clasificacionLead['clasificacion'] . '</option>';
										}
										?>
                  </select>
                  <p class="mensaje"></p>
                </div>
                <div class="mb-3 data-container" hidden="true" id="container-origen-lead">
                  <label for="origenlead" class="form-label">Origen Lead: </label>
                  <select id="origen-lead" class="form-select" name="origenLead">
                    <!-- Opciones clasificacion lead -->
                    <option value="" disabled selected>Seleccionar un origen...</option>
                    <?php
										foreach ($origenLeads as $origenLead) {
											echo '<option value="' . $origenLead['id'] . '">' . $origenLead['origen'] . '</option>';
										}
										?>
                  </select>
                  <p class="mensaje"></p>
                </div>
                <div class="mb-3 data-container">
                  <label for="rubrocomercial" class="form-label">Rubro Comercial: </label>
                  <select id="rubrocomercial" class="form-select" name="rubrocomercial"
                    placeholder="Seleccionar un rubro">
                    <!-- Opciones clasificacion lead -->
                    <option value="" disabled selected>Seleccionar un rubro...</option>
                    <?php
										foreach ($rubroSociales as $rubroSocial) {
											echo '<option value="' . $rubroSocial['id'] . '">' . $rubroSocial['rubroComercial'] . '</option>';
										}
										?>
                  </select>
                  <p class="mensaje"></p>
                </div>
                <div class="mb-3 data-container">
                  <label for="razonsocial" class="form-label">Razón Social: </label>
                  <select id="razonsocial" class="form-select" name="razonsocial">
                    <!-- Opciones clasificacion lead -->
                    <option value="" disabled selected>Seleccionar una razón...</option>
                    <?php
										foreach ($razonSociales as $razonSocial) {
											echo '<option value="' . $razonSocial['id'] . '">' . $razonSocial['razonSocial'] . '</option>';
										}
										?>
                  </select>
                  <p class="mensaje"></p>
                </div>
                <div hidden="true" id="btn-container-cotizacion">
                  <a href="./cotizacion/v_cotizacion.php?idTarea=" class="link-nueva-cotizacion"
                    id="link-nueva-cotizacion">
                    <img src="https://cdn-icons-png.flaticon.com/128/7164/7164888.png" alt="icono-cotizacion"
                      height="50px">
                    Generar cotización
                  </a>
                </div>
              </div>
            </div>
            <div class="table-conteiner">
              <div class="mb-3 conteiner-id-articulo">
                <p class="titulo-articulo">Artículos de interés</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalArticulos"
                  id="btn-articulos">
                  Seleccionar... <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
                </button>
              </div>
              <div id="table-container">
                <table id="table-articulos" class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col" class="th-col-row">Id</th>
                      <th scope="col" class="th-col-row">Artículo</th>
                      <th scope="col" class="th-col-row">Marca</th>
                      <th scope="col" class="th-col-row">Cantidad</th>
                    </tr>
                  </thead>
                  <tbody id="list-articulos" class="table-group-divider">
                    <!-- Articulos de interes -->
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Botones -->
            <div class="btn-guardar">
              <a href="./v_tarea.php"><button type="button" id="btn-cerrar2" class="btn btn-primary"><i
                    class="fa-solid fa-angle-left"></i> Cancelar</button></a>
              <button type="submit" id="btn-guardar" class="btn btn-secondary" name="actualizarTarea">
                <i class="fa-regular fa-floppy-disk"></i>
                Guardar
              </button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
  <?php
	require_once('modalClientes.html');
	require_once('modalArticulos.html');
	?>
  <script src="../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js "></script>
  <script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../Recursos/js/librerias/dataTables.bootstrap5.min.js"></script>
  <script src="../../Recursos/js/librerias/SweetAlert2.all.min.js"></script>
  <script src="../../Recursos/js/rendimiento/validacionesEditarTarea.js" type="module"></script>
  <script src="../../Recursos/js/rendimiento/v_editarTarea.js" type="module"></script>
</body>

</html>