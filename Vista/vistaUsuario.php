<table class="table">
  <thead >
    <tr>
      <th scope="col">ID USUARIO</th>
      <th scope="col">RTN</th>
      <th scope="col">USUARIO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">CONTRASEÑA</th>
      <th scope="col">CORREO ELECTRONICO</th>
      <th scope="col">ESTADO</th>
      <th scope="col">ROL</th>
      <th scope="col">INT_FALLLIDOS</th>
      <th scope="col">TELEFONO</th>
      <th scope="col">DIRECCION</th>
      <th scope="col">FECHA U CONEXION</th>
      <th scope="col">PREGUNTAS CONTESTADAS</th>
      <th scope="col">INGRESO USUARIO</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
  <?php
      require_once ("../db/Conexion.php");
      require_once ("../Modelo/Usuario.php");
      require_once("../Controlador/ControladorUsuario.php");
      $usuarios = ControladorUsuario::getUsuarios();
      foreach($usuarios as $user){
        echo '<tr>';
        foreach($user as $col){
          echo '<td>' .$col.'</td>';
        }
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</div>   