<?php
  require_once('validacionesNuevaContrasenia.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../../Recursos/css/login.css" rel="stylesheet" >
    <link href="../../Recursos/css/nuevaContrasenia.css" rel="stylesheet" >
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <title>Nueva contraseña</title>
</head>
<body id="body">
    <div class="ancho">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="formContrasenia">
            <div class="logo-empresa"  style="text-align: center">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="250px">
            </div>
            <h1 class="titulo">Configura tu nueva contraseña</h1>
            <div class="wrap-input mb-3">
            <span class="lock conteiner-icon">
                <i class="icon type-lock fa-solid fa-lock" id="lok1"></i>
            </span>
              <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña">
              <p class="mensaje"></p>
            </div>
            <div class="wrap-input mb-3">
              <span class="lock1 conteiner-icon">
                <i class="icon type-lock fa-solid fa-lock" id="lok2"></i>
              </span>
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmar contraseña" >
              <p class="mensaje"></p>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id="btn-submit">Cambiar</button>
            <a href="../login/login.php" class="btn btn-cancelar">Cancelar</a>

            <?php 
              if(!$mensaje == ''){
                echo '<h2 class="mensaje-error" style="margin-top: 8px;">'. $mensaje. '</h2>';
              }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
    <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <!-- <script src="../../Recursos/js/validacionesLogin.js" type="module"></script> -->
    <script src="../../Recursos/js/validacionesNuevaContrasenia.js" type ="module"></script>
</body>
</html>