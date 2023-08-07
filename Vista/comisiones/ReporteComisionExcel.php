<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=ReporteComision_General.xls");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Boostrap5 -->
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Comision </title>
</head>
<body>
  <div class="conteiner">
    <div class="row">
      <div class="columna2 col-10">
        <H1>Comisiones</H1>
        <div class= "table-conteiner">
          <!-- <div>
            <a href="#" class="btn_nuevoRegistro btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaComision"><i class="fa-solid fa-circle-plus"></i> Generar comisión</a>
          </div> -->
          <table class="table" id="table-Comision">
            <thead>
              <tr>
                <th scope="col"> ID COMISION </th>
                <th scope="col"> FACTURA </th>
                <th scope="col"> TOTAL VENTA </th>
                <th scope="col"> PORCENTAJE </th>
                <th scope="col"> COMISION TOTAL </th>
                <th scope="col"> FECHA </th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                require_once("../../db/Conexion.php");
                require_once("../../Modelo/Comision.php");
                require_once("../../Controlador/ControladorComision.php");
                $comision = ControladorComision::getComision();
                foreach ($comision as $comisiones) {
                ?>

                  <tr>
                    <td><?php echo $comisiones['idComision'] ?></td>
                    <td><?php echo $comisiones['factura'] ?></td>
                    <td><?php echo $comisiones['totalVenta'] ?></td>
                    <td><?php echo $comisiones['porcentaje'] ?></td>
                    <td><?php echo $comisiones['comisionTotal'] ?></td>
                    <td><?php echo $comisiones['fechaComision'] ?></td>
                  </tr>
                <?php
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="../../Recursos/js/comision/dataTableComision.js" type="module"></script>
  <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../Recursos/js/index.js"></script>
</body>

</html>