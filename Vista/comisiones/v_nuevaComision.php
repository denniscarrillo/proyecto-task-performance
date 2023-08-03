<?php
require_once('validacionesComision.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Nueva comision</title>
  <!-- Boostrap5 -->
  <link rel="stylesheet" href="../../Recursos/bootstrap5/bootstrap.min.css">
  <link href="../../Recursos/bootstrap5/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../Recursos/css/v_nuevaComision.css" rel="stylesheet">
  <link href='../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
</head>

<body>
  <div class="conteiner">
    <div class="row gx-0 row-conteiner">
      <div class="col-2 col-height">
        <?php
        $urlIndex = '../index.php';
        $urlGestion = '../crud/usuario/gestionUsuario.php';
        $urlTarea = '../rendimiento/v_tarea.php';
        $urlSolicitud = '../crud/solicitud/gestionSolicitud.php';
        $urlComision = 'v_comision.php';
        $urlVenta = '../crud/venta/gestionVenta.php';
        $urlCliente = '../crud/cliente/gestionCliente.php';
        $urlCarteraCliente = '../crud/carteraCliente/gestionCarteraClientes.php';
        require_once '../layout/sidebar.php';
        ?>
      </div>
      <div class="col-10 form-conteiner">
        <form>
          <div class="title-form">
            <div class="img-content">
              <img class="img" src="https://cdn-icons-png.flaticon.com/512/2953/2953536.png" height="50px">
            </div>
            <h2 class="text-title-form">Nueva comisión</h2>
          </div>
          <div class="form-element">
            <label>Fecha de ingreso</label>
            <input type="date" class="form-control" id="fecha-comision">
          </div>
          <!-- <div class="form-element">
            <label>ID comision</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="conteiner-id-venta form-element"">
            <label>Venta N°</label>
            <input type=" text" class="form-control" id="id-venta">
            <button type="button" class="btn-call-modal btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalfiltroVenta">
              Seleccionar...
            </button>
          </div>
          <div class="form-element">
            <label>Monto</label>
            <input type="text" class="form-control" id="monto-total">
          </div>
          <div class="form-element">
            <label>Porcentaje</label>
            <label id="mensaje-tipo-cliente"></label>
            <select name="porcentajeComision" class="form-control" id="porcentaje-comision">
              <option value="0">Seleccionar...</option>
              <?php
              foreach ($porcentajes as $porcentaje) {
                echo '<option value="' . $porcentaje['idPorcentaje'] . '">' . $porcentaje['porcentaje'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-element">
            <label>Comisión venta</label>
            <input type="text" class="form-control" id="comision-total">
          </div>
          <div class="form-element">
            <label>Vendedores:</label>
            <div class="conteiner-vendedores" id="conteiner-vendedores">
            </div>
          </div>
          <div class="form-element-btns">
            <button type="button" class="btn btn-primary" id="btn-guardar-comision">Guardar</button>
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
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="../../Recursos/js/comision/validacionesComision.js"></script>
  <script src="../../Recursos/js/index.js"></script>
</body>

</html>