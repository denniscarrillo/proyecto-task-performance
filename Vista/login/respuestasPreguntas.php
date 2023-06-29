<?php
    require_once('../../Vista/login/validarRespuestas.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../../Recursos/css/login.css" rel="stylesheet" />
    <link href="../../Recursos/css/configPreguntas.css" rel="stylesheet" />
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <title>Configuración Respuestas</title>
</head>
<body>
    <div class="ancho">
    <h2 class="titulo-bienvenida2">Ahora ingrese sus respuestas secretas</h2>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="150px">
            </div>
            <?php
                $i=0;
                foreach($preguntas as $pregunta)  { 
                    echo '<div class="input-conteiner">';
                    echo '<label class="inputs"> '.$pregunta['pregunta'].'</label>';
                    echo '<input type="text" name="respuesta'.$i .'" class="form-control">';
                    echo '</div>';
                    $i++;
                }
            ?>
            <button type="submit" class="btn btn-primary" name="submit">Continuar</button>
        </form>
        <?php 
            // echo '<h2 class="mensaje-error">'. $mensaje. '</h2>'
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/validacionesConfigPreguntas.js"></script>
</body>

</html>