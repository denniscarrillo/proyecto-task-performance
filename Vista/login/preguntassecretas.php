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
    

    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->


</head>
<body class="container">

    <div class="ancho">
        
        <form action= "<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="formPreguntas">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <h2 class ="titulo-registro">Recuperar contraseña</h2>
            <div class="wrap-input mb-3">
             
              <input type="text" class="form-control" name="userName" id="userName" maxlength="15" placeholder="Nombre Usuario">
              <p class="mensaje"></p>
            </div>
            
            <button id="userButton" type="submit" class="btn btn-primary" name="submit" >Comprobar</button>
            <a href = "login.php" class = "btn">Cancelar</a>

                <div class="wrap-input mb-3">
                    <label><strong>Para cambiar la contraseña ingrese el usuario que esta enlazado a la cuenta.</strong></label>
                </div>

              <form action="validarNombreUsuario.php" method="post">
              <div class="card-header">
              <div class="col-sm-7">
              
              <br> 
                <div class="col-9">
                   <!--<button onclick="" type="submit" class="btn btn-primary btn-block" value="verificar datos">Comprobar</button>-->
                   <!-- <script type= "text/javascript">
                   
                   
                   mostrar()
                   function mostrar(){
                    
                    swal('envio exitoso al correo');
                   }
                
                   </script> -->
                
                   
                   <!-- <a href = "preguntasResponder.php" class = "btn btn-primary btn-block" value="verificar datos">Comprobar</a> -->

            <?php 
              if(!$mensaje == ''){
                echo '<h2 class="mensaje-error">'. $mensaje. '</h2>';
              }
            ?>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/validacionesLogin.js"></script>
</body>
</html>