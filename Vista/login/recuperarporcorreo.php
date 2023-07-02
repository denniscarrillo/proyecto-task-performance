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
        <form action="../Vista/login/recovery.php" method="POST" id="formcorreo">
            <div class="logo-empresa">
                <img src="../../Recursos/imagenes/LOGO-HD-transparente.jpg" height="180px">
            </div>
            <h2 class="titulo-registro">Recuperar contraseña</h2>
            <div class="input-container">
                <div class="form-grupo">
                    <div class="wrap-input mb-3">
                        <label><strong>Para cambiar la contraseña, ingrese el usuario que está enlazado a la cuenta.</strong></label>
                    </div>
                    <div class="card-header">
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="user" name="userName" maxlength="50" placeholder="Nombre de usuario">
                            <p class="mensaje"></p>
                        </div>
                        <div class="col-9">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Enviar al correo</button>
                            <a href="recuperarcontrasena.php" class="btn">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="../../Recursos/js/validacioncorreo.js"></script>
    <script src="script.js"></script>
    <script>
        document.getElementById('formcorreo').addEventListener('submit', function(event) {
            event.preventDefault();

            if (validarFormulario()) {
                this.submit();
            }
        });
    </script>
</body>
</html>