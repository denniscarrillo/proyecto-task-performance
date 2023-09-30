<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once("../../../Controlador/ControladorUsuario.php");
 
   if(isset($_POST['guardar'])){
      $updateData=new Usuario();
      $updateData->usuario=$_SESSION['usuario'];
      $updateData->nombre=$_POST['nombre'];
      $updateData->rtn=$_POST['rtn'];
      $updateData->telefono=$_POST['telefono'];
      $updateData->direccion=$_POST['direccion'];
      $updateData->correo=$_POST['email'];
      $updateData->modificadoPor=$_SESSION['usuario'];
      ControladorUsuario::editarPerfilUsuario($updateData);
      header("location:./gestionPerfilUsuario.php");
   }

?>