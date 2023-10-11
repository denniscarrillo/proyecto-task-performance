<?php
    require_once('validarRespuestas.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <link href="../../Recursos/css/configRespuestas.css" rel="stylesheet" >
    <title>Configuración respuestas</title> 
</head>
<body>
    <div class="ancho">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formConfig">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="220px">
                <span class="estado-p-guardada" id="<?php echo (isset($p_guardada) && !empty($p_guardada)) ? $p_guardada : $p_guardada;?>"></span>
            </div>
            <p class="line-space"></p>
            <h1 class="titulo-bienvenida">Bienvenido(a) <?php echo $user ?></h1>
            <p class="line-space"></p>
            <h3 class="titulo-bienvenida2">Por favor, configure sus preguntas e ingrese su respuesta:</h3>
            <div>
                <select name="id_pregunta" class="select-preguntas form-select" id= "id_pregunta">
                    <option selected value="" disabled>Seleccionar...</option>
                        <?php
                            foreach ($preguntas as $pregunta){ 
                                echo '<option value="'.$pregunta['id_pregunta'].'">'.$pregunta['pregunta'].'</option>';
                            }
                        ?>
                </select>
                <p class="mensaje"></p>
            </div>
            <div class="wrap-input mb-3">
                <input type="text" name="respuesta" class="form-control input" id="respuesta" maxlength="50" placeholder="Respuesta">
                <p class="mensaje"></p>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id="btn-submit">Guardar</button>
            <?php 
            $cantPreguntasParametro = ControladorUsuario::cantidadPreguntas(); //Cantidad de preguntas a contestar parámetro
            $preguntasContestadasUsuario = ControladorUsuario::cantPreguntasContestadas($user);
             if($preguntasContestadasUsuario == 0){
               echo "<div class='info-content' id='".($preguntasContestadasUsuario)."'><i class='fa-solid fa-circle-info'></i><p class='mensaje-instruccion'>Debe configurar ".$cantPreguntasParametro." preguntas</p></div>";
             } else {
                echo "<div class='info-content' id='".($preguntasContestadasUsuario)."'><i class='fa-solid fa-circle-info'></i><p class='mensaje-instruccion'>Aún debe configurar ".($cantPreguntasParametro - $preguntasContestadasUsuario)." pregunta(s)</p></div>";
             }
            if(!empty($mensaje)){
                echo '<div class="message-container mensaje-error"><i class="fa-solid fa-circle-exclamation"></i><h2 class="message-text">'. $mensaje. '</h2></div>';
            }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../../Recursos/js/validacionesConfigPreguntas.js" type= "module"></script>
</body>
</html>