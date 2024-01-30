<?php
require_once('verificarToken.php');
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
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <link href="/Recursos/css/login.css" rel="stylesheet">
    <title>Solicitar Token</title>
</head>

<body class="container">
    <div class="ancho">
        <!-- Esto para detectar cuando viene de autoregistro y mostrarle un Toast con javascript -->
        <span class="tokenSend"
            id="<?php echo (isset($tokenSend) && intval($tokenSend) > 0) ? $tokenSend : 0; ?>"></span>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" id="formcorreo">
            <div class="logo-empresa" style="text-align: center">
                <img src="<?php echo '/Recursos/' . ControladorParametro::obtenerUrlLogo() ?>" height="220px">
            </div>
            <div style="display: flex; justify-content: center;">
                <p style="display: flex; justify-content: center; font-size: 2rem; font-weight: 500; width: 390px; 
        margin-bottom: 2rem; color: gray; text-transform: uppercase; background-color: #ffc90e; border-radius: 3rem;">
                    Task
                    Performance
                </p>
            </div>
            <div>
                <!-- <p class="line-space"></p> -->
                <h2 class="title-form">Para continuar, digite el token</h2>
                <!-- <p class="line-space"></p> -->
                <div class="wrap-input mb-3 mt-3">
                    <span class="conteiner-icon">
                        <i class="icon fa-sharp fa-solid fa-key" style="color: #ee7a1b;"></i>
                        <!-- <i class="icon fa-solid fa-lock-keyhole"></i> -->
                    </span>
                    <input type="text" class="form-control center-token" id="token" maxlength="4" pattern="[0-9]+"
                        name="token" placeholder="Ingresa el token">

                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Validar</button>
                <a href="./destruirSesionProceso.php?url=1" class="btn btn-secondary btn-cancel">Cancelar</a>
                <?php
                if (!empty($mensaje)) {
                    echo '<div class="message-container mensaje-error"><i class="fa-solid fa-circle-exclamation"></i><h2 class="message-text">' . $mensaje . '</h2></div>';
                }
                ?>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/validacionesToken.js"></script>
</body>

</html>