<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../../Recursos/css/restablecer.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <title>Registrarse</title>
</head>
<body class="container">
    <div class="ancho">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formRestablecer">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <h2 class ="titulo-registro">Restablecer Contraseña</h2>
            <div class = "input-container">
            <div class = "form-grupo">
            <div class = "form-grupo">
                <!-- input para Contraseña -->
                <div class="wrap-input mb-3" id="grupo__password">
                    <label><b>Contraseña</b></label>
                    <span class="lock conteiner-icon">
              <i class="icon type-lock fa-solid fa-lock"></i>
              </span>
                    <input type="password" class="form-control input" name="clave1" id="clave1" maxlength="15" placeholder="Contraseña">
                   <!--  <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                    <p class="mensaje"></p>
                    <br>
                </div>
                <!-- input para confirmación Contraseña -->
                <div class="wrap-input mb-3" id="grupo__password2">
                    <label><b>Confirmar contraseña</b></label>
                    <span class="lock conteiner-icon">
              <i class="icon type-lock fa-solid fa-lock"></i>
              </span>
                    <input type="password" class="form-control input" name="clave2" id="clave2" maxlength="15" onClick="comprobarClave()" placeholder="Confirmar Contraseña">
                    <!-- <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                    <p class="mensaje"></p>
                </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary" onClick="comprobarClave()"  name="submit" id= "click">Enviar</button>
            <br>
            <a href="http://localhost:3000/Vista/login/login.php" class="btn btn-primary btn-block" style="margin-top: 0.8rem; background-color: #f68e3e;">Cancelar</a>
            </br>
            <!-- <?php 
              /* if(!$mensaje==''){
                echo '<h2 class="mensaje-error">'. $mensaje. '</h2>';
              } */
            ?> -->
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
    <script src="../../Recursos/js/validacionesRestablecer.js" type="module"></script>
</body>

</html>