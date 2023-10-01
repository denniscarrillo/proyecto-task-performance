<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Permiso.php");
   require_once("../../../Controlador/ControladorPermiso.php");
   
   session_start(); //Reanudamos la sesion
   if(isset($_SESSION['usuario']) && $_POST['idObjeto']){
      $permisosRol = ControladorPermiso::obtenerPermisosUsuarioObjeto($_SESSION['usuario'], intval($_POST['idObjeto']));
      print json_encode($permisosRol, JSON_UNESCAPED_UNICODE);
   }