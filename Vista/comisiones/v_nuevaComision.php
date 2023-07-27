<?php
  require_once('validacionesComision.php');
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <title>Nueva comision</title>
    <!-- Boostrap5 -->
    <link href="../../Recursos/boostrap5/bootstrap.min.css" rel="stylesheet">
    <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
    <!-- Boxicons CSS -->
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="../../Recursos/css/v_nuevaComision.css" rel="stylesheet">
</head>
<body>
<div class="conteiner">
  <div class="row gx-0">
    <div class="col-2">
      <?php
      $urlIndex = '../../index.php';
      $urlGestion = '../usuario/gestionComision.php';
      $urlTarea = '../../rendimiento/v_tarea.php';
      $urlSolicitud = '../solicitud/gestionSolicitud.php';
      $urlComision = '../comision/gestionComision.php';
      $urlVenta = '../venta/gestionVenta.php';
      $urlCliente ='./cliente/gestionCliente.php';
      $urlCarteraCliente = './carteraCliente/gestionCarteraClientes.php';
      require_once '../layout/sidebar.php';
      ?>
    </div>
    <div class="col-10">
    </div>
    <div class="form-conteiner">
          <form>
            <h1>Comisión</h1>
            <div>
                <label>Fecha de ingreso</label>
                <input type="date" class="form-control">
            </div>
            <div>
                <label>Comision</label>
                <input type="text" class="form-control">
            </div>
            <div>
                <label>Id de la venta</label>
                <input type="text" class="form-control">
            </div>
            <div>
                <label>Monto</label>
                <input type="text" class="form-control">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaComision">
                Buscar
                </button>
                <!-- <button type="button" id="Buscar" class="btn btn-primary">Buscar</button> -->
            </div>
            <div>
                <label>Porcentaje</label>
                <input type="text" class="form-control">
            </div>
            <div>
                <label>Vendedores</label>
                <input type="text" class="form-control">
            </div>
            <div>
        
                <button type="button" class="btn btn-secondary">Guardar</button>
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
          </form>
        </div>
  </div>
</div>
  <?php
  require_once 'modalFiltroVenta.html';
  require_once 'modalVentas.html';
  ?>
  <script src="../../Recursos/boostrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
</body>
</html>