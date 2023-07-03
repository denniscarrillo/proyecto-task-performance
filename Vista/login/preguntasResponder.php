<?php
  require_once('verificarUsuarioPreguntas.php');
  $preguntas = '';
    if(!isset($_POST["Respuesta"])){
      session_start();
      $_SESSION['user'] = $_POST["userName"];
    }
    if(isset($_SESSION['user'])){
      // session_start();
      $usuario = $_SESSION['user'];
      $preguntas = ControladorUsuario::getPreguntas($usuario);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="http://localhost/EquiposCocinas/Recursos/css/recuperarporcorreo.css" rel="stylesheet" />
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Registrarse</title>
</head>
<body class="container">
  <div class="ancho">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formpreguntasresponder">
      <div class="logo-empresa">
        <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
      </div>
      <h2 class="titulo-registro">Recuperar contraseña</h2>
      <div class="input-container">
        <div class="wrap-input mb-3">
          <label><strong>Responda las preguntas guardadas en su perfil.</strong></label>
        </div>
        <p>Pregunta de Seguridad:</p>
        <div class="col-sm-7">
          <select class="txt" name="pregunta">
            <?php
            foreach ($preguntas as $pregunta) {
              echo '<option value="' . $pregunta['id_Pregunta'] . '">' . $pregunta['pregunta'] . '</option>';
            }
            ?>
          </select>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="preguntasecretas" name="Respuesta" id="Respuesta" placeholder="Respuesta">
            <?php
              echo $mensaje;
            ?>
          </div>
          <div class="col-sm-7">
            <a href="login.php" class="btn">Cancelar</a>
            <button type="submit" class="btn" name="submit">Responder</button>
          </div>
        </div> 
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../../Recursos/js/validacioncorreo.js"></script>
</body>
</html>