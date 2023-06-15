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
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <h2 class ="titulo-registro">Crea tu cuenta</h2>
            <div class = "input-container">
            <div class = "form-grupo">
                <!-- input para nombre -->
                <div class="wrap-input mb-3">
                    <label><strong>Nombre Completo</strong></label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                </div>
                <!-- input para RTN del usuario -->
                <div class="wrap-input mb-3">
                    <label><strong>RTN usuario</strong></label>
                    <input type="text" class="form-control" name="rtnUsuario" placeholder="RTN Usuario">
                </div>
                <!-- input para Contraseña -->
                <div class="wrap-input mb-3">
                    <label><strong>Contraseña</strong></label>
                    <input type="text" class="form-control" name="contraseña" placeholder="Contraseña">
                </div>
            </div>
            <div class = "form-grupo">
                <!-- input para usuario -->
                <div class="wrap-input mb-3">
                    <label><strong>Usuario</strong></label>
                    <input type="text" class="form-control" name="usuario" placeholder="Usuario">
                </div>
                <!-- input para telefono -->
                <div class="wrap-input mb-3">
                    <label><strong>Teléfono</strong></label>
                    <input type="text" class="form-control" name="telefono" placeholder="Teléfono">
                </div>
                <!-- input para confirmación Contraseña -->
                <div class="wrap-input mb-3">
                    <label><strong>Confirmar contraseña</strong></label>
                    <input type="text" class="form-control" name="confirmarContraseña" placeholder="Confirmar Contraseña">
                </div>
            </div>
            <div class = "form-grupo">
                <!-- input para correo electronico -->
                <div class="wrap-input mb-3">
                    <label><strong>Correo Electrónico</strong></label>
                    <input type="text" class="form-control" name="correoElectronico" placeholder="Correo Electrónico">
                </div>
                <!-- input para direccion -->
                <div class="wrap-input mb-3">
                    <label><strong>Dirección</strong></label>
                    <input type="text" class="form-control" name="direccion" placeholder="Dirección">
                </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Registrar</button>
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
    <script src="../../Recursos/js/validacionesLogin.js"></script>
</body>

</html>