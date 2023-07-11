<?php
  require_once ("../../db/Conexion.php");
  require_once ("../../Modelo/Usuario.php");
  require_once("../../Controlador/ControladorUsuario.php");
  $mensaje = '';
  if (isset($_POST['submit'])){
    $password = $_POST['password'];
    $password1 = $_POST['password2'];
    session_start(); //Reanudamos sesion
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        if($password == $password1){
            //Guardar contraseña anterior en la tabla historial contraseña.
            $respaldada = ControladorUsuario::respaldarContrasenia($user);
            if($respaldada){
              $encriptPassword = password_hash($password, PASSWORD_DEFAULT);
                //Actualizar a la nueva contraseña en la tabla usuario.
                ControladorUsuario::actualizarContrasenia($user, $encriptPassword);
                header('location: ../login/login.php');
                session_destroy();
            }
        } else {
          $mensaje = 'Deben coincidir ambas contraseñas!';
        }
    }
  }


