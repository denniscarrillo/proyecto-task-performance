<?php
    require_once('validarRespuestas.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../../Recursos/css/login.css" rel="stylesheet" />
    <link href="../../Recursos/css/configRespuestas.css" rel="stylesheet" />
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <title>Configuración respuestas</title> 
</head>
<body>
    <div class="ancho">
    <?php 
     $usuario = '';
        echo '<h1 class="titulo-bienvenida">Bienvenido '.$user.'!</h1>';
    ?>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="logo-empresa">
<<<<<<< HEAD
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="px">
=======
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="200px">
>>>>>>> Prueba
            </div>
            <h3 class="titulo-bienvenida2">Por favor elija una pregunta e ingrese su respuesta:</h3>
            <select name="id_pregunta" class="select-preguntas form-select">
            <option selected>Seleccionar...</option>
                <?php
                    foreach ($preguntas as $pregunta){ 
                        echo '<option value="'.$pregunta['id_pregunta'].'">'.$pregunta['pregunta'].'</option>';
                    }
                ?>
            </select>
            <input type="text" name="respuesta" class="form-control input">
            <button type="submit" class="btn btn-primary" name="submit">Guardar</button>
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