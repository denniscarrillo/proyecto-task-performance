<?php
require_once('../../Vista/login/validarRegistro.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="http://localhost/EquiposCocinas/Recursos/css/registro.css" rel="stylesheet" />
    <!-- <link href="http://localhost/EquiposCocinas/Recursos/css/registro.css" rel="stylesheet" /> -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <title>Registrarse</title>
</head>
<body class="container">
    <div class="ancho">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formRegis">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <h2 class ="titulo-registro">Crea tu cuenta</h2>
            <div class = "input-container">
            <div class = "form-grupo">
                <!-- input para nombre -->
                <div class="wrap-input mb-3">
                    <label><b>Nombre Completo</b></label>
                    <input type="text" class="form-control input" name="nombre" id="nombre" maxlength="30" placeholder="Nombre">
                    <p class="mensaje"></p>
                </div>
                
                <!-- input para usuario -->
                <div class="wrap-input mb-3">
                    <label><b>Usuario</b></label>
                    <span class="conteiner-icon">
                  <i class="icon fa-solid fa-user"></i>
                </span>
                    <input type="text" class="form-control input" name="usuario" id="usuario" maxlength="14" placeholder="Usuario">
                    <p class="mensaje"></p>
                </div>
                <!-- input para correo electronico -->
                <div class="wrap-input mb-3">
                    <label><b>Correo Electrónico</b></label>
                    <input type="text" class="form-control input" name="correoElectronico" id="correo" maxlength="35" placeholder="Correo Electrónico">
                    <p class="mensaje"></p>
                </div>
            </div>
            <div class = "form-grupo">
                <!-- input para Contraseña -->
                <div class="wrap-input mb-3" id="grupo__password">
                    <label><b>Contraseña</b></label>
                    <span class="lock conteiner-icon">
              <i class="icon type-lock fa-solid fa-lock"></i>
              </span>
                    <input type="password" class="form-control input" name="contraseña" id="password" maxlength="15" placeholder="Contraseña">
                   <!--  <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                    <p class="mensaje"></p>
                </div>
                <!-- input para confirmación Contraseña -->
                <div class="wrap-input mb-3" id="grupo__password2">
                    <label><b>Confirmar contraseña</b></label>
                    <span class="lock conteiner-icon">
              <i class="icon type-lock fa-solid fa-lock"></i>
              </span>
                    <input type="password" class="form-control input" name="confirmarContraseña" id="password2" maxlength="15" placeholder="Confirmar Contraseña">
                    <!-- <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                    <p class="mensaje"></p>
                </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id= "click">Registrar</button>
            <?php 
              if(!$mensaje==''){
                echo '<h2 class="mensaje-error">'. $mensaje. '</h2>';
              }
            ?>
            <label>¿Ya tienes cuenta? </label><a href = "login.php">Inicia sesión</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/validacionesRegistro.js"></script>
</body>

</html>