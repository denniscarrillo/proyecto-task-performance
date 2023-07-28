<?php
  require_once('validacionesTarea.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <link rel="stylesheet" href="../../Recursos/boostrap5/bootstrap.min.css">
  <link rel="stylesheet" href="../../Recursos/css/layout/sidebar.css">
  <link rel="stylesheet" href="../../Recursos/css/tarea.css">
  <link rel="stylesheet" href="../../Recursos/css/modalEditarTarea.css">
  <title>Tareas</title>
</head>
<body>
  <div class="conteiner">
    <div class="row gx-0">
      <div class="col-2">
        <?php
          $urlIndex = '../index.php';
          $urlGestion = '../crud/usuario/gestionUsuario.php';
          $urlTarea = 'v_tarea.php';
          $urlSolicitud = '../crud/solicitud/gestionSolicitud.php';
          $urlComision = '../comisiones/v_comision.php';
          $urlCrudComision = '../crud/comision/gestionComision.php';
          $urlVenta = '../crud/venta/gestionVenta.php';
          $urlCliente = '../crud/cliente/gestionCliente.php';
          $urlCarteraCliente = '../crud/carteraCliente/gestionCarteraClientes.php';
          require_once '../layout/sidebar.php';
        ?>
      </div>
      <div class="col-10">
        <div class="row gx-0 encabezado">
          <h2>Tus tareas</h2>
        </div>
        <div class="row gx-0 conteiner_col">
          <!-- LLamadas -->
          <div class="col-3" id="columna-llamadas">
            <div class="title-task">
              <p class="title-task-label">Llamada</p>
              <p class="circle-count" id="circle-count-llamadas"></p>
            </div>
            <button type="button" class="btn_nuevaTarea btn btn-primary" id="btn-NuevaLLamada">+ Nueva llamada</button>
            <div class="container_tarea" id="conteiner-llamada">
              <!-- Aqui van las tareas llamadas -->
            </div>
          </div>
          <!-- Leads -->
          <div class="col-3" id="columna-leads">
            <div class="title-task">
              <p class="title-task-label">Lead</p>
              <p class="circle-count" id="circle-count-leads"></p>
            </div>
            <button type="button" class="btn_nuevaTarea btn btn-primary" id= "btn-NuevoLead">+ Nuevo lead</button>
            <div class="container_tarea" id="conteiner-lead">
              <!-- Aqui van las tareas leads -->
            </div>
          </div>
          <!-- Cotizaciones -->
          <div class="col-3" id="columna-cotizaciones">
            <div class="title-task">
              <p class="title-task-label">Cotización</p>
              <p class="circle-count" id="circle-count-cotizaciones"></p>
            </div>
            <button type="button" class="btn_nuevaTarea btn btn-primary" id= "btn-NuevaCotizacion">+ Nueva Cotizacion</button>
            <div class="container_tarea" id="conteiner-cotizacion" >
              <!-- Aqui van las tareas leads -->
            </div>
            <!-- <button>+ Nueva Tarea</button> -->
          </div>
          <!-- Venta -->
          <div class="col-3" id="columna-ventas"> 
            <div class="title-task">
              <p class="title-task-label">Venta</p>
              <p class="circle-count" id="circle-count-ventas"></p>
            </div> 
            <button type="button" class="btn_nuevaTarea btn btn-primary" id= "btn-NuevaVenta">+ Nueva Venta</button>
            <div class="container_tarea" id="conteiner-venta">
            <!-- Aqui van las tareas leads -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  require('modalEditarTarea.html');
  ?>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../Recursos/boostrap5/bootstrap.min.js "></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/index.js"></script>
  <script src="../../Recursos/js/rendimiento/tarea.js"></script>
</body>
</html>