<?php
	require_once('./validacionesEditarTarea.php');
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
	<link rel='stylesheet' href='../../Recursos/css/layout/navbar.css' >
	<link rel='stylesheet' href='../../Recursos/css/layout/footer.css' >
	<link rel='stylesheet' href="../../Recursos/css/layout/sidebar.css">
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
				$urlConsultarTareas = '../crud/DataTableTarea/gestionDataTableTarea.php'; 
				$urlBitacoraTarea = ''; //PENDIENTE
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
				$urlPermisos = '../crud/permiso/gestionPermiso.php';
				$urlRoles = '../crud/rol/gestionRol.php';
				$urlPorcentajes = '../crud/Porcentajes/gestionPorcentajes.php';
				$urlServiciosTecnicos = '../crud/TipoServicio/gestionTipoServicio.php';
				$urlPerfilUsuarios='../crud/PerfilUsuario/gestionPerfilUsuario.php';
				$urlPerfilContraseniaUsuarios='../crud/PerfilUsuario/gestionPerfilContrasenia.php';
				$urlImg = '../../Recursos/imagenes/Logo-E&C.png';
				require_once '../layout/sidebar.php';
			?>
		</div>
		<div class="conteiner-main">
			
			<div class="navbar-conteiner">
				<!-- Aqui va la barra -->
				<?php include_once '../layout/navbar.php'?>
			</div>
			<!-- Cuerpo de la pagina -->
			<main class="main">
			<div class="conteiner-form">
				<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="form-Edit-Tarea">
					<div class="encabezado-tarea">
						<div class="mb-3">
							<label class="text-cliente">Tipo cliente:</label>
							<input type="radio" name="radioOption" id="cliente-existente" class="radio" value="Existente"><label for="cliente-existente" class="radio-label form-label">Existente</label>
							<input type="radio" name="radioOption" id="cliente-nuevo" class="radio" value="Nuevo" checked><label for="cliente-nuevo" class="radio-label form-label">Nuevo</label>
						</div>
						<div class="mb-3">
							<label id="<?php echo $_GET['estadoTarea']; ?>" class="id-tarea" hidden="true"></label>
							<input type="text" value="<?php echo $_GET['idTarea'];?>" id="id-Tarea" class="id-tarea" name="idTarea" hidden="true">
							<label for="estados-tarea" class="form-label"> Estado: </label>
							<label id="estado-tarea"></label>
							<select name="estadoTarea" id="estados-tarea" class="form-control">
								<!-- Opciones estados de tarea -->
								<?php
									foreach($estadosTarea as $estado){
										echo '<option value="'.$estado['idEstado'].'">'.$estado['estado'].'</option>';
									}
								?>
							</select>
							<p class="mensaje"></p>
						</div>
					</div>
					<div id="group-inputs">
						<!-- Columna 1 -->
						<div class="grupo-form">
							<div class="mb-3" id="container-rtn-cliente">
								<label for="rnt-cliente" class="form-label">RTN:</label>
								<p id="mensaje"></p>
								<input type="text" name="rtnCliente" id="rnt-cliente" class="form-control">
								<!-- Aqui va el boton del filtro de clientes -->
							</div>
							<div class="mb-3">
								<label for="nombre" class="form-label">Nombre Cliente:</label>
								<input type="text" name="nombre" id="nombre-cliente" class="form-control">
								<p class="mensaje"></p>
							</div>
							<div class="mb-3">
								<label for="telefono" class="form-label">Teléfono: </label>
								<input type="text" name="telefono" id="telefono-cliente" class="form-control">
								<p class="mensaje"></p>
							</div>
							<div class="mb-3" id="container-correo">
								<label for="correo" class="form-label">Correo Electrónico: </label>
								<input type="email" name="correo" id="correo-cliente" class="form-control">
								<p class="mensaje"></p>
							</div>
						</div>
						<!-- Columna 2 -->
						<div class="grupo-form">
							<div class="mb-3">
								<label for="direccion" class="form-label">Dirección: </label>
								<input type="text" name="direccion" id="direccion-cliente" class="form-control">
								<p class="mensaje"></p>
							</div>
							<div class="mb-3" id="container-clasificacion-lead" hidden="true">
								<label for="clasificacionlead" class="form-label">Clasificación Lead: </label>
								<select id="clasificacion-lead" class="form-control " name="clasificacionLead">
								<!-- Opciones clasificacion lead -->
								<option value="">Seleccionar...</option>
								<?php
									foreach($clasificacionLeads as $clasificacionLead){
										echo '<option value="'.$clasificacionLead['id'].'">'.$clasificacionLead['clasificacion'].'</option>';
									}
								?>
								</select>
								<p class="mensaje"></p>
							</div>
							<div class="mb-3" hidden="true" id="container-origen-lead">
								<label for="origenlead" class="form-label">Origen Lead: </label>
								<select id="origen-lead" class="form-control " name="origenLead">
								<!-- Opciones clasificacion lead -->
								<option value="">Seleccionar...</option>
								<?php
									foreach($origenLeads as $origenLead){
										echo '<option value="'.$origenLead['id'].'">'.$origenLead['origen'].'</option>';
									}
								?>
								</select>
								<p class="mensaje"></p>
							</div>
							<div class="mb-3">
								<label for="rubrocomercial" class="form-label">Rubro Comercial: </label>
								<input type="text" name="rubrocomercial" id="rubrocomercial" class="form-control">
								<p class="mensaje"></p>
							</div>
							<div class="mb-3">
								<label for="razonsocial" class="form-label">Razón Social: </label>
								<input type="text" name="razonsocial" id="razonsocial" class="form-control">
								<p class="mensaje"></p>
							</div>
						</div>
					</div>
					<div class="table-conteiner">
						<div class="mb-3 conteiner-id-articulo">
							<p class="titulo-articulo">Artículos Interés</p>
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalArticulos" id="btn-articulos">
								Seleccionar... <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
							</button>
						</div>
						<table id="table-articulos" class="table table-striped">
							<thead>
								<tr>
									<th scope="col">Id</th>
									<th scope="col">Artículo</th>
									<th scope="col">Marca</th>
									<th scope="col">Cantidad</th>
								</tr>
							</thead>
							<tbody id="list-articulos" class="table-group-divider">
								<!-- Articulos de interes -->
							</tbody>
						</table>
					</div>
					<!-- Botones -->
					<div class="btn-guardar">
						<a href="./v_tarea.php"><button type="button" id="btn-cerrar2" class="btn btn-secondary">Cancelar</button></a>
						<button type="submit" id="btn-guardar" class="btn btn-primary" name="actualizarTarea"><i class="fa-solid fa-floppy-disk"></i>Guardar</button>
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
<script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js "></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="../../Recursos/js/rendimiento/v_editarTarea.js"></script>
  <!-- <script src="../../Recursos/js/rendimiento/validacionesEditarTarea.js" ></script> -->
</body>
</html>