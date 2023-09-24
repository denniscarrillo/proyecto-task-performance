<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- DataTables -->
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <!-- Boostrap5 -->
    <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
    <link href='../../../Recursos/css/v_nueva_solicitud.css' rel='stylesheet'>
      <!-- Estilos personalizados -->
    <link href="../../../Recursos/css/gestionComision.css" rel="stylesheet">
    <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
    <title>Nueva solicitud</title>
</head>
<body>
<div class="conteiner">
    <div class="conteiner-global">
        <div class="sidebar-conteiner">
            <?php
                $urlIndex = '../../index.php';
                // Rendimiento
                $urlMisTareas = '../../rendimiento/v_tarea.php';
                $urlConsultarTareas = './'; //PENDIENTE
                $urlBitacoraTarea = ''; //PENDIENTE
                $urlMetricas = '../Metricas/gestionMetricas.php';
                $urlEstadisticas = ''; //PENDIENTE
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
                //Mantenimiento
                $urlUsuarios = '../usuario/gestionUsuario.php';
                $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
                $urlPreguntas = '../pregunta/gestionPregunta.php';
                $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
                $urlParametros = '../parametro/gestionParametro.php';
                $urlPermisos = '../permiso/gestionPermiso.php';
                $urlRoles = '../rol/gestionRol.php';
                $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
                $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
                require_once '../../layout/sidebar.php';
            ?>
      </div>
      <div class="conteiner-main">
      <div class= "encabezado">
            <div class="navbar-conteiner">
                <!-- Aqui va la barra -->
                <?php include_once '../../layout/navbar.php'?>                             
            </div>        
            <div class ="titulo">
                  <H2 class="title-dashboard-task">Generar nueva solicitud</H2>
            </div>  
      </div>   
        <div class="form-conteiner">
            <div class="form-element">
                <label>Tipo cliente solicitud: </label>
                <label for="tipo-cliente-nuevo">Nuevo </label>
                <input type="checkbox" id="tipo-cliente-nuevo">
                <label for="tipo-cliente-frecuente">Frecuente </label>
                <input type="checkbox" id="tipo-cliente-frecuente">
                <label for="tipo-cliente-venta">venta </label>
                <input type="checkbox" id="tipo-cliente-venta">
            </div>
            <form action="" id="form-solicitud">
                <div class="group-form">
                    <div class="form-element input-conteiner">
                        <label for="id-factura">N° Factura</label>
                        <input type="text" id="id-factura" class="form-control">
                    </div>
                    <div class="form-element input-conteiner">
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" class="form-control">
                    </div>
                    <div class="form-element input-conteiner">
                        <label for="correo">Correo electronico</label>
                        <input type="email" id="correo" class="form-control">
                    </div>
                    <div class="form-element input-conteiner">
                        <label for="id-descripcion">Ubicación instalación</label>
                        <input type="text" id="id-descripcion" class="form-control">
                    </div>
                </div>
                <div class="group-form">
                    <div class="form-element input-conteiner">
                        <label for="fecha-solicitud">Fecha solicitud</label>
                        <input type="date" id="fecha-solicitud" class="form-control">
                    </div>
                    <div class="form-element input-conteiner">
                        <label for="tipo-solicitud">Tipo solicitud</label>
                        <input type="text" id="tipo-solicitud" class="form-control">
                    </div>
                    <div class="form-element input-conteiner">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" class="form-control">
                    </div>
                </div>
                <!-- <div class="form-element">
                    <label for="id-descripcion"></label>
                    <input type="text" id="id-descripcion" class="form-control">
                </div> -->
            </form>
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
        </div>
      </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
<script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
</body>
</html>