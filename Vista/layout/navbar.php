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
  <link rel="stylesheet" href="ruta/al/archivo.css">
  <!--  Tipos de letra -->


  <link href="../../../Recursos/css/modalSalir.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/modalSalir.css' rel='stylesheet'>
</head>

<body>
<nav class="navbar">
  <div class="container-fluid">
    <a class="navbar-brand"></a>
    <form class="d-flex">
      <!-- Menú desplegable - Información del usuario -->
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Perfil
        </button>
        <div class="dropdown-menu" aria-labelledby="userMenu">
          <!-- <a class="dropdown-item" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Ajustes
          </a> -->
          <a class="dropdown-item" href="#">
           <!--  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Logotipo de actividad
          </a> -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../../Vista/layout/modalSalir.php" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Cerrar Sesión
          </a>
        </div>
      </div>
    </form>
  </div>
</nav>

  <!-- Page Heading -->
    <span class="container">
      <h1>Bienvenido.</h1>
      <p>Sistema Cocinas y Equipos.</p>
    </span>
  
<!-- para cargar la imagen -->
  <img src="../../Recursos/imagenes/cocina.jpg" class="img-fluid" alt="imagen">

</html>
