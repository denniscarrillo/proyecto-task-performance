
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <!-- Boostrap5 -->
    <link href='../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
    <!-- Boxicons CSS -->
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href='../../Recursos/css/estadisticas.css' rel='stylesheet'>
    <title>Gráfica</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <link href='../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
    <link href='../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
    <link href='../../Recursos/css/layout/navbar.css' rel='stylesheet'>
    <link href='../../Recursos/css/layout/footer.css' rel='stylesheet'>
</head>
<body style="overflow: hidden;">
    <!-- Sidebar 1RA PARTE -->
    <div class="conteiner-global">
        <div class="sidebar-conteiner sidebar locked">
            <?php
            $urlIndex = '../index.php';
            // Rendimiento
            $urlMisTareas = '../rendimiento/v_tarea.php';
            $urlConsultarTareas = '../crud/DataTableTarea/gestionDataTableTarea.php'; //PENDIENTE
            $urlBitacoraTarea = ''; //PENDIENTE
            $urlMetricas = '../crud/Metricas/gestionMetricas.php';
            $urlEstadisticas = './estadistica.php'; //PENDIENTE
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
            $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
            require_once '../layout/sidebar.php';
          ?>
        </div>    

        <div class="conteiner-main">

                <!-- Encabezado -->
            <div class= "encabezado">
                <div class="navbar-conteiner">
                    <!-- Aqui va la barra -->
                    <?php include_once '../layout/navbar.php'?>                             
                </div>        
                <div class ="titulo">
                    <H2 class="title-dashboard-task">Graficas</H2>
                </div>  
            </div>

            <div class="Graficoss" >
                <div class="filtros">
                    <div class="filtro-fecha">
                        <label for="fechaDesde">Fecha desde:</label>
                        <input type="date" id="fechaDesdef" name="fechaDesdef" class="form-control">
                        <label for="fechaHasta">Fecha hasta:</label>
                        <input type="date" id="fechaHastaf" name="fechaHastaf" class="form-control">
                    </div>
                    
                    <div class="filtro-Input"> 
                        
                        <form> 
                            <fieldset> 
                                <legend>Elige el tipo de gráfico</legend>
                                <input type="radio" id="general" name="fav_language" value="General" checked>
                                <label for="html">General</label><br>
                                <input type="radio" id="porVendedor" name="fav_language" value="Por Vendedor">
                                <label for="css">Por Vendedor</label><br>
                            </fieldset> 
                        </form>    
                    </div>
                    
                    <div class="filtro-PorVendedor" id="PorVendedor">
                        <label for="PorTarea" class="form-label">Seleccione Vendedores:</label>
                        <button type="button" class="btn btn-primary btn-success" id="btnVendedores" data-bs-toggle="modal"  
                        data-bs-target="#modalTraerVendedores">Seleccionar Vendedores...<i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i></button>
                    </div> 

                    
                    <button type="button" class="btn btn-primary" id="btnFiltrar">Filtrar</button>

                </div> 
                 
                <div class="grafica_Tareas">
                    <canvas id="grafica"  style="display: flow-root; width: 1333px; height: 366px;" class="chartjs-render-monitor"></canvas>
                </div>

                <div class= "graficosPorTareas">
                    <div class="grafica_Llamada">
                        <canvas id="grafica_llamada" style=" width: 1333px; height: 366px;" ></canvas>
                    </div>   
                    
                    <div class="grafica_Lead">
                        <canvas id="grafica_lead" style=" width: 1333px; height: 366px;" ></canvas>
                    </div>
                    
                    <div class="grafica_Cotizacion">
                        <canvas id="grafica_Cotizacion" style=" width: 1333px; height: 366px;" ></canvas>
                    </div>
                    <div class="grafica_Ventas">
                        <canvas id="grafica_Ventas" style=" width: 1333px; height: 366px;" ></canvas>
                    </div>
                </div>
                
            </div>
            
                <!-- Footer -->
            <div class="footer-conteiner">
                    <?php
                    require_once '../layout/footer.php';
                    //require_once('./modalFiltroVendedores.html');
                    ?>
            </div>
        </div>
    </div>
    <?php
       require_once('modalFiltroVendedores.html');
    ?>
    
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
    <script src="../../../Recursos/js/grafica/script.js"></script>  
     <script src="../../../Recursos/js/index.js"></script>
     
</body>

</html>