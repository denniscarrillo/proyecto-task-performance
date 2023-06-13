<table class="table">
  <thead >
    <tr>
      <th scope="col">ID USUARIO</th>
      <th scope="col">USUARIO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">CONTRASEÑA</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
  <?php
      require_once('Controlador/ControladorUsuario.php');
      #require_once('db/ConexionDB.php');
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