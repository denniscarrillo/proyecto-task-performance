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
                <div class="container-cotizacion">
                    <div class="datos-cotizacion">
                        <div class="colum-horizontal">
                            <div class="input-cotizacion" id="input-cotizacion">
                                <label for="n-cotizacion" class="" id="label-correo">Cotización N° </label>
                                <label for="n-cotizacion" class="" id="label-correo">******************</label>
                            </div>
                            <div id="input-fecha">
                                <label for="fecha" class="form-label" id="label-fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" >
                                <p class="mensaje"></p>
                            </div>
                        </div>
                        <div class="mb-3" id="input-cotizacion">
                                    <label for="n-cotizacion" class="form-label" id="label-correo">Cliente: </label>
                                    <label for="n-cotizacion" class="form-label" id="label-correo">**********************</label>
                            </div>
                            <div class="mb-3" id="input-telefono">
                                <label for="telefono" class="form-label" id="label-correo">Teléfono</label>
                                <label for="validez" class="form-label" id="label-correo">******************</label>
                            </div>
                            <div class="mb-3" id="input-vendedor">
									<label for="vendedor" class="form-label" id="label-title-vendedor">Vendedor</label>
                                    <label for="validez" class="form-label" id="label-vendedor">*****************</label>
							</div>
                            <div class="mb-3" id="input-validez">
                                <label for="validez" class="form-label" id="label-correo">Validez</label>
                                <input type="number" name="validez" id="validez" class="form-control" >
                                <p class="mensaje"></p>
                            </div>
                    </div>
                    <div class="productos-cotizacion">
                        <div class="nuevo-producto">
                            <input type="text" id="id-producto" class="fila-producto" placeholder="Id producto">
                            <input type="text" name="descripcion" id="descripcion" class="fila-producto" placeholder="Descripción">
                            <input type="text" name="marca" id="marca" class="fila-producto" placeholder="Marca">
                            <input type="number" name="cantidad" id="cantidad" class="fila-producto" placeholder="Cantidad">
                            <input type="text" name="precio" id="precio" class="fila-producto" placeholder="Precio">
                            <input type="button" class="btn-agregar-producto" id="btn-agregar-producto" value="Agregar">
                        </div>
                        <table id="productos-cotizacion" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="th-col-row">ID PRODUCTO</th>
                                    <th class="th-col-row">DESCRIPCION</th>
                                    <th class="th-col-row">MARCA</th>
                                    <th class="th-col-row">CANTIDAD</th>
                                    <th class="th-col-row">PRECIO</th>
                                    <th class="th-col-row">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="t-body">
                                <tr class="table-footer">
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
                                    <label for="sub-total" class="" id="label-correo">SubTotal</label>
                                    <input type="text" name="sub-total" id="sub-total" class="form-control" >
                                </div>
                                <div class="align-in-column" id="input-descuento">
                                    <label for="descuento" class="form-label" id="label-correo">Descuento</label>
                                    <input type="text" name="descuento" id="descuento" class="form-control" >
                                </div>
                                <div class="align-in-column" id="input-sub-descuento">
                                    <label for="sub-descuento" class="form-label" id="label-correo">Sub Descuento</label>
                                    <input type="text" name="sub-descuento" id="sub-descuento" class="form-control" >
                                </div>
                                <div class="align-in-column" id="input-impuesto">
                                    <label for="impuesto" class="form-label" id="label-correo">15% I.S.V</label>
                                    <input type="text" name="impuesto" id="impuesto" class="form-control" >
                                </div>
                                <div class="align-in-column" id="input-total">
                                    <label for="total" class="form-label" id="label-correo">Total</label>
                                    <input type="text" name="total" id="total" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

			</main>
        </div>
	</div>
	<script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
	<script src="../../../Recursos/bootstrap5/bootstrap.min.js "></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
	<script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
	<script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>-->
	<script src="../../Recursos/js/rendimiento/cotizacion/v_cotizacion.js"></script> 
</body>
</html>