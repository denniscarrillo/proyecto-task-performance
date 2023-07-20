<?php
  require_once('validacionesTarea.php');
  $contLlamada = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../Recursos/boostrap5/bootstrap.min.css">
  <link rel="stylesheet" href="../../Recursos/css/layout/sidebar.css">
  <link rel="stylesheet" href="../../Recursos/css/tarea.css">
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
          $urlComision = '../crud/comision/gestionComision.php';
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
          <div class="col-3">
            <div class="title-task">
              <p>Llamada</p>
              <p class="circle-count"><?php echo count($llamadas); ?></p>
            </div>
            <button class = "btn_nuevaTarea">+ Nueva Tarea</button>
            <div class="container_llamada" >
                <?php 
                  foreach($llamadas as $llamada){
                      echo '<div class="card_task"><p>'.$llamada['tituloTarea'].'</p>';
                      echo '<p>'.$llamada['fechaInicio'].'</p></div>';
                  }
                ?>
            </div>
          </div>
          <!-- Leads -->
          <div class="col-3">
            <div class="title-task">
              <p>Lead</p>
              <p class="circle-count"><?php echo count($leads); ?></p>
            </div>
            <button class = "btn_nuevaTarea">+ Nueva Tarea</button>
            <div class="container_llamada" >
                <?php 
                  foreach($leads as $lead){
                      echo '<div class="card_task"><p>'.$lead['tituloTarea'].'</p>';
                      echo '<p>'.$lead['fechaInicio'].'</p></div>';
                  }
                ?>
            </div>
          </div>
          <!-- Cotizaciones -->
          <div class="col-3">
            <div class="title-task">
              <p>Cotización</p>
              <p class="circle-count"><?php echo count($cotizaciones); ?></p>
            </div>
            <button class = "btn_nuevaTarea">+ Nueva Tarea</button>
            <div class="container_llamada" >
                <?php 
                  foreach($cotizaciones as $cotizacion){
                      echo '<div class="card_task"><p>'.$cotizacion['tituloTarea'].'</p>';
                      echo '<p>'.$cotizacion['fechaInicio'].'</p></div>';
                  }
                ?>
            </div>
            <!-- <button>+ Nueva Tarea</button> -->
          </div>
          <!-- Venta -->
          <div class="col-3"> 
            <div class="title-task">
              <p>Venta</p>
              <p class="circle-count"><?php echo count($ventas); ?></p>
            </div> 
            <button class = "btn_nuevaTarea">+ Nueva Tarea</button>
            <div class="container_llamada" >
                <?php 
                  foreach($ventas as $venta){
                      echo '<div class="card_task"><p>'.$venta['tituloTarea'].'</p>';
                      echo '<p>'.$venta['fechaInicio'].'</p></div>';
                  }
                ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../../Recursos/boostrap5/bootstrap.min.js "></script>
  <script src="../../Recursos/js/index.js"></script>
</body>
</html>