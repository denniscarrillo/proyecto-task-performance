<?php
require_once('verificarUsuarioPreguntas.php');
$preguntas = '';
if (isset($_SESSION['usuario'])) {
  $usuario = $_SESSION['usuario'];
  $preguntas = ControladorUsuario::getPreguntas($usuario);
  $_SESSION['configRespuestas'] = '0';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <link href="../../Recursos/css/login.css" rel="stylesheet">
  <link href="../../Recursos/css/preguntasResponder.css" rel="stylesheet">
  <title>Pregunta secreta</title>
</head>

<body class="container">
  <div class="ancho">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formPreguntasRes">
      <div class="logo-empresa">
        <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="220px">
      </div>
      <div class="input-container">
        <p class="line-space"></p>
        <h2 class="title-form">Preguntas de Seguridad</h2>
        <p class="line-space"></p>
        <select name="pregunta" class="select-preguntas form-select" id="preguntas">
          <?php
          foreach ($preguntas as $pregunta) {
            echo '<option value="' . $pregunta['id_Pregunta'] . '">' . $pregunta['pregunta'] . '</option>';
          }
          ?>
        </select>
        <div class="wrap-input mb-3">
          <input type="text" class="form-control"  name="Respuesta" id="Respuesta" maxlength="50" placeholder="Respuesta">
          <p class="mensaje"></p>
        </div>
        <div class="btn-container mt-4">
          <a href="./v_recuperarContrasena.html" class="btn btn-secondary btn-cancel">Cancelar</a>
          <button type="submit" class="btn btn-primary btn-block" name="submit">Responder</button>
        </div>
        <?php 
          if(!empty($mensaje) && !empty($mensaje2)){
            echo '<div class="message-container mensaje-error"><i class="fa-solid fa-circle-exclamation"></i><h2 class="message-text">'. $mensaje. '</h2></div>';
            echo "<div class='info-content' style='margin-top: 0.3rem;'><i class='fa-solid fa-circle-info'></i><p class='mensaje-instruccion'>".$mensaje2."</p>";
          } else if(!empty($mensaje)) {
            echo '<div class="message-container mensaje-error"><i class="fa-solid fa-circle-exclamation"></i><h2 class="message-text">'. $mensaje. '</h2></div>';
          }
        ?>
      </div>
  </div>
  </div>
  </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../Recursos/js/validacionesPreguntasResponder.js" type ="module"></script>
</body>

</html>