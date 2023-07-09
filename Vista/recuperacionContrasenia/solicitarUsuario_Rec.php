<?php
    require_once("validacionesRecuperacion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="/Recursos/css/login.css" rel="stylesheet" />
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <title>Solicitar usuario</title>
</head>
<body class="container">
    <div class="ancho">
        <?php
            // if($opcion == 'correo'){
            //     echo '<form action="solicitarUsuario_Rec.php" method="POST" id="formcorreo">';
            // } else {
            //     echo '<form action="../recuperacionContrasenia/preguntasResponder.php" method="POST" id="formcorreo">';
            // }
        ?>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="formcorreo">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <div>
                <h2 style="font-size: 1.5rem;">Nombre de usuario</h2>
                <div class="wrap-input mb-3">
                    <span class="conteiner-icon">
                        <i class="icon fa-solid fa-user"></i>
                    </span>
                    <input type="text" class="form-control" id="user" name="userName" maxlength="20" placeholder="Usuario">
                </div>
            </div>
            <div class="wrap-input">
                <?php
                    if($opcion == 'correo'){
                        $texto = 'Enviar correo';
                    } else {
                        $texto = 'Continuar';
                    }
                    echo '<button type="submit" class="btn btn-primary btn-block" name="submit">'.$texto.'</button>';
                ?>
                <a href="v_recuperarContrasena.html" class="btn btn-primary btn-block" style="margin-top: 0.8rem; background-color: #f68e3e;">Regresar</a>
            </div>
            <?php
            if($mensaje != ''){
                echo '<p>'.$mensaje.'</p>';
            }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>

</body>
</html>