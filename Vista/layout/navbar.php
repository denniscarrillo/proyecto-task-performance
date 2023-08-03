<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dash</title>
  <!-- Enlaces a Bootstrap y Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <!-- Enlace a Font Awesome (si es necesario) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Enstilo css (si es necesario) -->
  <link rel="stylesheet" href="style.css">
  <!--  Tipos de letra -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
<nav class="navbar">
  <div class="container-fluid">
    <a class="navbar-brand"></a>
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-success" type="submit">Buscar</button>
    </form>
  </div>
</nav>

  <!-- Page Heading -->
  </iv>
    <span class="container">
      <h1>Bienvenido.</h1>
      <p>Sistema cosinas y equipos.</p>
    </span>
  </div>
<!-- para cargar la imagen -->
  <img src="../../Recursos/imagenes/cocina.jpg" class="img-fluid" alt="imagien">

  <div>
   <a class="btn_Venta" href="/Vista/crud/venta/gestionVenta.php"><i class="fa-solid fa-cash-register"></i> Ventas...</a>
 </div>
  <br>

  <div>
    <a class="btn_Rendimiento" href="#"><i class="fa-solid fa-square-poll-vertical"></i> Rendimiento...</a>
  </div>
  <br>

  <div>
   <a class="btn_Comisiones" href="/Vista/comisiones/v_comision.php"><i class="fa-solid fa-money-bill"></i>
   Comisiones...</a>
  </div>
  <br>

  <div>
 <a class="btn_Clientes" href="/Vista/crud/cliente/gestionCliente.php"><i class="fa-solid fa-user-group"></i>
      Clientes...</a>
  </div>
  <br>

  <div>
<a class="btn_Mantenimiento" href="#" class="btn_Mantenimiento btn btn-danger"><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento...</a>
 </div>
<br>

  <!-- Enlace a Font Awesome (si es necesario) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
