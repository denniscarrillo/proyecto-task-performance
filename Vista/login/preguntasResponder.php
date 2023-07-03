<?php
require_once('../../Vista/login/validarNombreUsuario.php');
?>
<!DOCTYPE html>

<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="http://localhost/EquiposCocinas/Recursos/css/recuperarporcorreo.css" rel="stylesheet" />
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <title>Registrarse</title>

    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->


</head>
<body class="container">

    <div class="ancho">
        
        <form action= "<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formpreguntasresponder">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <h2 class ="titulo-registro">Recuperar contraseña</h2>
            <div class = "input-container">
            <div class = "form-grupo">
                <!-- para recuperar la contrasena del usuario en el sistema-->
                <div class="wrap-input mb-3">
                    <label><strong>Responda las preguntas guardadas en su perfil.</strong></label>
                </div>

                          
              <form action="validarNombreUsuario.php" method="post">
              <div class="card-header">
              <div class="col-sm-7">

              <br /><br />

                Pregunta de Seguridad : <br />

                <?php
        $preguntas = ControladorUsuario::getPreguntas();
        foreach($preguntas as $pregunta){
          
          foreach($pregunta as $col){
            echo '<option>' .$col.'</option>';
          }
          
        }
      ?>

              <select class="txt" name="que">
                	<option>¿Quién es tu mejor amig@?</option>
                    <option>¿Cuál es el nombre de tu mascota?</option>
                    <option>¿Cuál es tu mes preferido??</option>
              </select>

              
              <input type="text" class="form-control" id="preguntasecretas" name="Respuesta" id="Respuesta" maxlength="15" placeholder="Respuesta"  >
              <p class="mensaje"></p>

              <br> 
                
                  

                   <a href = "login.php" class = "btn">Cancelar</a>
                   <a href = "reseteocontrasena.php" class = "btn">Submit</a>
                   
                </div>    
               
                </br>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/validacioncorreo.js"></script>
</body>
</html>