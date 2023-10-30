<?php
    require_once('./validacionesCotizacion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva cotización</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/6889/6889345.png" >
    <!-- Hojas de estilos externas -->
    <link rel="stylesheet" href="../../../Recursos/bootstrap5/bootstrap.min.css">
    <!-- Hojas de estilos personalizadas -->
    <link rel='stylesheet' href='../../../Recursos/css/layout/estilosEstructura.css'>
    <link rel='stylesheet' href="../../../Recursos/css/layout/sidebar.css">
    <link rel='stylesheet' href='../../../Recursos/css/layout/navbar.css'>
</head>
<body style="overflow: hidden;">
	<!-- Sidebar -->
	<div class="conteiner-global">
		<div class="sidebar-conteiner">
			<?php
                $urlIndex = '../../index.php';
                // Rendimiento
                $urlMisTareas = '../v_tarea.php';
                $urlConsultarTareas = '../../crud/DataTableTarea/gestionDataTableTarea.php';
                $urlBitacoraTarea = ''; //PENDIENTE
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
                $urlCarteraCliente = '../../crud/carteraCliente/gestionCarteraClientes.php';
                $urlPreguntas = '../../crud/pregunta/gestionPregunta.php';
                $urlParametros = '../../crud/parametro/gestionParametro.php';
                $urlPermisos = '../../crud/permiso/gestionPermiso.php';
                $urlRoles = '../../crud/rol/gestionRol.php';
                $urlPorcentajes = '../../crud/Porcentajes/gestionPorcentajes.php';
                $urlServiciosTecnicos = '../../crud/TipoServicio/gestionTipoServicio.php';
                $urlPerfilUsuarios = '../../crud/PerfilUsuario/gestionPerfilUsuario.php';
                $urlPerfilContraseniaUsuarios = '../../crud/PerfilUsuario/gestionPerfilContrasenia.php';
                $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
                require_once '../../layout/sidebar.php';
			?>
		</div>
		<div class="conteiner-main">
			<div class="navbar-conteiner">
				<!-- Aqui va la barra -->
				<?php include_once '../../layout/navbar.php';?>
			</div>
			<!-- Cuerpo de la pagina -->
			<main class="main">
                <div class="encabezado">
                    <h2 class="title-dashboard-task" id="<?php echo ControladorBitacora::obtenerIdObjeto('v_tarea.php');?>" name='v_tarea.php' >Nueva Cotización</h2>
                </div>

			</main>
        </div>
	</div>
	<script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
	<script src="../../../Recursos/bootstrap5/bootstrap.min.js "></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
	<script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
	<script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
	<script src="../../Recursos/js/rendimiento/v_editarTarea.js" type="module"></script> -->
</body>
</html>