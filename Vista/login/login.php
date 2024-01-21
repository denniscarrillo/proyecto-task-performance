<?php
require_once('validacionesLogin.php');
require_once('../../Modelo/Parametro.php');
require_once('../../Controlador/ControladorParametro.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="../../Recursos/css/login.css" rel="stylesheet">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Iniciar sesión</title>
</head>

<body id="body">
  <div class="ancho">
    <!-- Esto para detectar cuando viene de autoregistro y mostrarle un Toast con javascript -->
    <span class="registro-exitoso"
      id="<?php echo (isset($registro) && intval($registro) > 0) ? $registro :  0; ?>"></span>

    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formLogin">
      <div class="logo-empresa" style="text-align: center;">
        <img src="<?php echo '../../Recursos/' . ControladorParametro::obtenerUrlLogo() ?>" height=" 220px">
      </div>
      <div style="display: flex; justify-content: center;">
        <p style="display: flex; justify-content: center; font-size: 2rem; font-weight: 500; width: 390px; 
        margin-bottom: 2rem; color: gray; text-transform: uppercase; background-color: #ffc90e; border-radius: 3rem;">
          Task
          Performance
        </p>
      </div>
      <div class="wrap-input mb-4.5">
        <span class="conteiner-icon">
          <i class="icon fa-solid fa-user"></i>
        </span>
        <input type="text" class="form-control" name="userName" id="userName" placeholder="Usuario">
        <p class="mensaje"></p>
      </div>
      <div class="wrap-input mb-4.5">
        <span class="lock conteiner-icon">
          <i class="icon type-lock fa-solid fa-lock"></i>
        </span>
        <input type="password" class="form-control" id="userPassword" name="userPassword" maxlength="20"
          placeholder="Contraseña">
        <p class="mensaje"></p>
      </div>
      <button type="submit" class="btn btn-primary" name="submit" id="btn-submit">Iniciar sesión</button>
      <label class="btn-cuenta">¿Aún no tienes cuenta? </label><a href="registro.php">Regístrate</a>
      <a href="../recuperacionContrasenia/v_recuperarContrasena.php">¿Olvidaste tu usuario y/o contraseña?</a>
      <?php
      if (!empty($mensaje)) {
        echo '<div class="message-container mensaje-error"><i class="fa-solid fa-circle-exclamation"></i><h2 class="message-text">' . $mensaje . '</h2></div>';
      }
      ?>
    </form>
  </div>
  <script src="../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../Recursos/js/librerias/Kit.fontawesome.com.2317ff25a4.js"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../Recursos/js/librerias/SweetAlert2.all.min.js"></script>
  <script src="../../Recursos/js/validacionesLogin.js" type="module"></script>
</body>

</html>