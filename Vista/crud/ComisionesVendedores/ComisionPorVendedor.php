
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Comision Total Por Vendedor</title>
  <!-- Boostrap5 -->
  <link rel="stylesheet" href="../../../Recursos/bootstrap5/bootstrap.min.css">
  <link href="../../../Recursos/bootstrap5/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../../Recursos/css/gestionComision.css" rel="stylesheet" />
  <link href="../../../Recursos/css/ComisionesPorVendedor.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
</head>

<body>
  <div class="conteiner">
    <div class="row gx-0 row-conteiner">
      <div class="col-2 col-height">
        <?php
        $urlIndex = '../index.php';
        $urlGestion = '../crud/usuario/gestionUsuario.php';
        $urlTarea = '../../rendimiento/v_tarea.php';
        $urlSolicitud = '../solicitud/gestionSolicitud.php';
        $urlComision = '../../comisiones/v_comision.php';
        $urlCrudComision = '../comision/gestionComision.php';
        $urlComisionVendedor = '../ComisionesVendedores.php';
        $urlVenta = '../crud/venta/gestionVenta.php';
        $urlCliente = '../crud/cliente/gestionCliente.php';
        $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
        $urlPorcentaje = '../Porcentajes/gestionPorcentajes.php';
        $urlMetricas = '../crud/Metricas/gestionMetricas.php';
        $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
        require_once '../../layout/sidebar.php';
        ?>
      </div>
      <div class="col-10 form-conteiner">
        <form action="" method="post" id="form-Comision">
          <div class="title-form">
            <div class="img-content">
              <img class="img" src="https://cdn-icons-png.flaticon.com/512/2953/2953536.png" height="50px">
            </div>
            <h2 class="text-title-form">Comision Total Por Vendedor</h2>
          </div>
          <div class="form-element">
            <label>Fecha de ingreso</label>
            <input type="date" class="form-control" id="fecha-comisionV">
          </div>
          <!-- <div class="form-element">
            <label>ID comision</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="conteiner-id-comision form-element-btns">
            <label>Comisiones por vendedor</label>
            <input type=" text" class="form-control" id="id-comisionV">
            <button type="button" class="btn-call-modal btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalfiltroComisiones">
              Seleccionar...
            </button>
          </div>
        </form>
      </div>z
    </div>
  </div>
  <?php
  require_once 'modalFiltroComisiones.html';
  require_once 'modalComisionesV.html';
  ?>
  <script src="../../../Recursos/js/librerias/it.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../../Recursos/js/librerias/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/librerias/dataTables.bootstrap5.min.js"></script>
  <script src="../../../Recursos/js/comision/validacionesComision_V.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
</body>
<!-- Se debe corregir algunas cosas -->
</html>
