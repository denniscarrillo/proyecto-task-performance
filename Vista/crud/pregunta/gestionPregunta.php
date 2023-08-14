<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Pregunta.php");
require_once("../../../Controlador/ControladorPregunta.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Controlador/ControladorUsuario.php");
session_start(); //Reanudamos la sesion

 if(isset($_SESSION['usuario'])){
   /* ====================== Evento ingreso a mantenimiento de usuario. =====================*/
   $newBitacora = new Bitacora();
   $accion = ControladorBitacora::accion_Evento();
   date_default_timezone_set('America/Tegucigalpa');
   $newBitacora->fecha = date("Y-m-d h:i:s"); 
   $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
   $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
   $newBitacora->accion = $accion['income'];
   $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingreso a mantenimiento usuario';
   ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
   /* =======================================================================================*/
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <link href="../../../Recursos/css/gestionComision.css" rel="stylesheet" />
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Pregunta </title>
</head>

<body>
  <div class="conteiner">
    <div class="row">
      <div class="columna1 col-2">
        <?php
        $urlIndex = '../../index.php';
        $urlGestion = '../usuario/gestionUsuario.php';
        $urlTarea = '../../rendimiento/v_tarea.php';
        $urlSolicitud = '../solicitud/gestionSolicitud.php';
        $urlComision = '../../comisiones/v_comision.php';
        $urlCrudComision = '../comision/gestionComision.php';
        $urlVenta = 'gestionVenta.php';
        $urlCliente = '../cliente/gestionCliente.php';
        $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
        $urlRoles = '../../../Vista/crud/rol/gestionRol.php';
        $urlPreguntas = '../../../Vista/crud/pregunta/gestionPregunta.php';
        
        require_once '../../layout/sidebar.php';
        ?>
      </div>
      <div class="columna2 col-10">
        <H1>Gestión de Preguntas</H1>
        <div class="table-conteiner">
        <div>
        <a href="#" class="btn_nuevoRegistro btn btn-primary" id="btn_nuevoRegistro" data-bs-toggle="modal" data-bs-target="#modalNuevaPregunta"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
        <a href="../../fpdf/ReportePregunta.php" target="_blank" class="btn_Pdf btn btn-primary" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a> 
        </div>
          <table class="table" id="table-Pregunta">
            <thead>
              <tr>
                <th scope="col"> N° </th>
                <th scope="col"> PREGUNTA </th>
                <th scope="col"> ACCIONES </th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php
  require('modalNuevaPregunta.html');
  require('modalEditarPregunta.html');
  ?>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/pregunta/dataTablePregunta.js" type="module"></script>
  <script src="../../../Recursos/js/pregunta/validacionesModalNuevaPregunta.js" type="module"></script>
  <script src="../../../Recursos/js/pregunta/validacionesModalEditarPregunta.js" type="module"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <!--<script src="../../../Recursos/js/validacionesModalEditarUsuario.js" type="module"></script>-->
</body>

</html>