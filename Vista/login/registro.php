<?php
require_once('../../Vista/login/validarRegistro.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="../../Recursos/css/registro.css" rel="stylesheet">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Registrarse</title>
</head>

<body class="container">
  <div class="ancho">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formRegis">
      <div class="logo-empresa">
        <img src="<?php echo '/Recursos/' . ControladorParametro::obtenerUrlLogo() ?>" height="220px">
      </div>
      <div style="display: flex; justify-content: center;">
        <p
          style="display: flex; justify-content: center; font-size: 2rem; font-weight: 500; width: 390px; 
                margin-bottom: 2rem; color: gray; text-transform: uppercase; background-color: #ffc90e; border-radius: 3rem;">
          Task
          Performance
        </p>
      </div>
      <p class="line-space"></p>
      <h2 class="titulo-registro">Crear nueva cuenta</h2>
      <p class="line-space"></p>
      <div class="input-container">
        <div class="form-grupo">
          <!-- input para nombre -->
          <div class="wrap-input mb-3">
            <label style="font-weight: 700;"><span style="color: red;">*</span>Nombre completo</label>
            <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Nombre del usuario">
            <p class="mensaje"></p>
          </div>
          <!-- input para usuario -->
          <div class="wrap-input mb-3">
            <label style="font-weight: 700;"><span style="color: red;">*</span>Usuario</label>
            <input type="text" class="form-control input" name="usuario" id="usuario"
              placeholder="Cuenta de usuario">
            <p class="mensaje"></p>
          </div>
          <!-- input para correo electronico -->
          <div class="wrap-input mb-3">
          <label style="font-weight: 700;"><span style="color: red;">*</span>Correo electrónico</label>
            <input type="text" class="form-control input" name="correoElectronico" id="correo"
              placeholder="ejemplo123@gmail.com">
            <p class="mensaje"></p>
          </div>
        </div>
        <div class="form-grupo">
          <!-- input para Contraseña -->
          <div class="wrap-input mb-3" id="grupo__password">
          <label style="font-weight: 700;"><span style="color: red;">*</span>Contraseña</label>
            <input type="password" class="form-control input" name="contraseña" id="password" placeholder="Establecer contraseña">
            <p class="mensaje"></p>
          </div>
          <!-- input para confirmación Contraseña -->
          <div class="wrap-input mb-3" id="grupo__password2">
          <label style="font-weight: 700;"><span style="color: red;">*</span>Confirmar contraseña</label>
            <input type="password" class="form-control input" name="confirmarContraseña" id="password2"
              placeholder="Confirme su contraseña">
            <!-- <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
            <p class="mensaje"></p>
          </div>
          <div class="show_password">
            <input type="checkbox" id="checkbox"> Mostrar Contraseñas
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="submit" id="btn_crearCuenta">Registrar cuenta</button>
      <label>¿Ya tienes cuenta?</label><a href="login.php" class="label-text">Iniciar sesión</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../Recursos/js/validacionesRegistro.js" type="module"></script>
</body>

</html>