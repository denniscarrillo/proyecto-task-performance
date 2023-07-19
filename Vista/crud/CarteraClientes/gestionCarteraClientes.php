<?php
  require_once ("../../../db/Conexion.php");
  require_once ("../../../Modelo/CarteraClientes.php");
  require_once("../../../Controlador/ControladorCarteraClientes.php");
  session_start(); //Reanudamos la sesion
  
  
 
 // if(isset($_SESSION['usuario'])){
 //   /* ====================== Evento ingreso a mantenimiento de usuario. =====================*/
 //   $newBitacora = new Bitacora();
 //   $accion = ControladorBitacora::accion_Evento();
 //  date_default_timezone_set('America/Tegucigalpa');
 //   $newBitacora->fecha = date("Y-m-d h:i:s"); 
 //   $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
 //   $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
 //   $newBitacora->accion = $accion['income'];
 //   $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingreso a mantenimiento usuario';
 //   ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
 //   /* =======================================================================================*/
 // }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <link href="../../../Recursos/css/gestionUsuario.css" rel="stylesheet" />
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet" >
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Prueba </title>
</head>
<body class="conteiner">
  <H1>Gestión de Cartera de Clientes</H1>
  <div class="table-conteiner">

  <div>
    <a href="#"  class="btn_nuevoRegistro btn btn-primary" id="btn_nuevoRegistro" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
  </div>
  
    <table class="table" id="table-CarteraClientes">
      <thead>
      <tr>
          <th scope="col"> ID CLIENTE </th>
          <th scope="col"> NOMBRE </th>
          <th scope="col"> RTN </th>
          <th scope="col"> TELEFONO </th>
          <th scope="col"> CORREO </th>
          <th scope="col"> ESTADO DE CLIENTE </th>
          
      </tr>    
      </thead>
      <tbody class="table-group-divider">
      </tbody>
  </table>
</div>
<?php
  require('modalNuevoCliente.html');
  //require('modalEditarUsuario.html');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
<script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src= "../../../Recursos/js/CarteraClientes/datatable.js" type="module"></script>
<script src= "../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
<!--<script src="../../../Recursos/js/validacionesModalNuevoUsuario.js"  type="module"></script>-->
<!--<script src="../../../Recursos/js/validacionesModalEditarUsuario.js" type="module"></script>-->
</body>
</html>