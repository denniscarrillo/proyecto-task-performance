<?php
  require_once ('../../db/Conexion.php');
  require_once ('../../Modelo/Usuario.php');
  require_once ('../../Controlador/ControladorUsuario.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="../../Recursos/css/gestionUsuario.css" rel="stylesheet" />
  <title> Prueba </title>
</head>
<body class="conteiner">
  <H1>Gestión de Usuarios</H1>
  <div class="table-conteiner">
  <div>
    <button class="btn-Acciones"> Nuevo Usuario </button>
  </div>
    <table class="table" id="table">
      <thead>
      <tr>
          <th scope="col"> USUARIO </th>
          <th scope="col"> NOMBRE </th>
          <th scope="col"> CONTRASEÑA </th>
          <th scope="col"> CORREO </th>
          <th scope="col"> ESTADO </th>
          <th scope="col"> ROL </th>
          <th scope="col"> ACCIONES </th>
      </tr>    
      </thead>
      <tbody class="table-group-divider">
      <?php
        $usuarios = ControladorUsuario::getUsuarios();
        foreach($usuarios as $user){
          echo '<tr>';
          foreach($user as $col){
            echo '<td>' .$col.'</td>';
          }
          echo '<td><button class="btn-Acciones">Editar</button><button class="btn-Acciones">Eliminar</button></td>';
          echo '</tr>';
        }
      ?>
      </tbody>
  </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src= "../../Recursos/js/librerias/dataTable.js"></script>
</body>
</html>