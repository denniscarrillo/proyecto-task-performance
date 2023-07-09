<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="../Recursos/css/index.css" rel="stylesheet" >
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='../Recursos/css/index.css' rel='stylesheet'>
    <title>Prueba</title>
</head>
<body id="body">
  <nav class="sidebar close" id="nav">
      <header>
        <div class="text logo">
          <span class="name">Equipos y Cocinas</span>
        </div>
        <i class="bx bx-menu toggle" id="toggle"></i>
      </header>
      <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="nav-link">
                  <a href="index.php">
                    <i class="bx bx-home-alt icon"></i>
                    <span class="text btn-inicio">Inicio</span>
                  </a>
                </li>
                <li class="nav-link">
                  <a href="crud/usuario/gestionUsuario.php">
                    <i class="bx bxs-user-badge icon"></i>
                    <span class="text btn-inicio">Gestión de Usuario</span>
                  </a>
                </li>
                <li class="nav-link">
                  <a href="">
                    <i class="bx bxs-cog icon"></i>
                    <span class="text btn-inicio">Configuración</span>
                  </a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
          <li class="">
              <a href="login/login.php">
                <i class="bx bx-log-out-circle icon"></i>
                <span class="text btn-inicio">Cerrar sesión</span>
              </a>
          </li>
          <!-- <li class="mode">
              <div class="claro-oscuro">
                <i class="bx bx-moon icon"></i>
                <i class="bx bx-sun icon"></i>
                <span class="mode-text text">Modo Oscuro</span>
              </div>
              <div class="toggle-switch">
                <span class="switch">Modo Oscuro</span>
              </div>
          </li> -->
        </div>
      </div>
  </nav>
  <script src="../Recursos/js/validacionesIndex.js"></script>
</body>
</html>