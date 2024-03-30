<?php
    header("refresh:4;url=./index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
    <title>Sin permiso</title>
</head>
<body>
    <style>
      .message-conteiner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        max-width: 100%;
        height: 100vh;
        background-color: #dde2e5;
        font-size: 2rem;
      }
    .titulo {
        margin-bottom: 0;
        color: #e96b23;
    }
    .sub-titulo {
        margin-bottom: 0;
        color: #d42e11;
        font-size: 1.5rem;
    }
    </style>
    <div class="message-conteiner">
        <p class="titulo"> Lo sentimos!</p>
        <p class="sub-titulo"> No tienes permiso para acceder a está sección del sistema. Por favor, contacta al administrador para obtener ayuda.</p>
    </div>
</body>
</html>