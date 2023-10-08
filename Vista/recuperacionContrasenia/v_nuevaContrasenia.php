<?php
  require_once('validacionesNuevaContrasenia.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <link href="../../Recursos/css/login.css" rel="stylesheet" >
    <link href="../../Recursos/css/nuevaContrasenia.css" rel="stylesheet" >
    <title>Nueva contraseña</title>
</head>
<body id="body">
    <div class="ancho">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="formContrasenia">
            <div class="logo-empresa"  style="text-align: center">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="250px">
            </div>
            <p class="line-space"></p>
            <h1 class="title-form">Configura tu nueva contraseña</h1>
            <p class="line-space"></p>
            <div class="wrap-input mb-3 mt-3">
              <input type="password" class="form-control" name="password" id="password" maxlength = "15" placeholder="Nueva contraseña">
              <p class="mensaje mb-0"></p>
            </div>
            <div class="wrap-input mb-1">
              <input type="password" class="form-control" id="confirmPassword" maxlength="15" name="confirmPassword" placeholder="Confirmar contraseña" >
              <p class="mensaje mb-0"></p>
            </div>
            <div class="show-password-container">
              <input type="checkbox" id="checkbox">
              <label class="label-text">Mostrar contraseñas</label>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id="btn-submit">Cambiar</button>
            <a href="../login/login.php" class="btn btn-secondary btn-cancel">Cancelar</a>
            <?php 
              if(!empty($mensaje)){
                echo '<h2 class="mensaje-error" style="margin-top: 8px;">'. $mensaje. '</h2>';
              }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
    <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../../Recursos/js/validacionesNuevaContrasenia.js" type ="module"></script>
</body>
</html>