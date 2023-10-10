
<?php
session_start(); //Reanudamos la sesion
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once ("../../../Modelo/Pregunta.php");
require_once("../../../Controlador/ControladorPregunta.php");
require_once("actualizarPerfilUsuario.php");
require_once("actualizarPreguntasUsuario.php");

$data = ControladorUsuario::obtenerDatosPerfilUsuario($_SESSION['usuario']);
$preguntas = ControladorPregunta::obtenerPreguntasXusuario($_SESSION['usuario']);

if (isset($_SESSION['usuario'])) {
 
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $permisoRol = ControladorUsuario::permisosRol($idRolUsuario);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionUsuario.php');
  $objetoPermitido = ControladorUsuario::permisoSobreObjeto($_SESSION['usuario'], $idObjetoActual, $permisoRol);
  if(!$objetoPermitido){
    /* ==================== Evento intento de ingreso sin permiso a mantenimiento usuario. ==========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionUsuario.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a mantenimiento usuario';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  }else{
    if(isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])){
      /* ====================== Evento salir. ================================================*/
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s");
      $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Exit'];
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de '.$_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    }
    /* ====================== Evento ingreso a mantenimiento usuario. ========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionUsuario.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a mantenimiento usuario';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionUsuario.php';
    $_SESSION['descripcionObjeto'] = 'mantenimiento usuario';
    /* =======================================================================================*/
  }
} else {
  header('location: ../../login/login.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7563/7563276.png">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- DataTables -->
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Estilos personalizados -->
  <link href="../../../Recursos/css/EditarCamposPerfilUsuario.css" rel="stylesheet" />
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <title> Actualizar Perfil</title>
</head>

<body  style="overflow: hidden;">
  <div class="conteiner">
    <div class="conteiner-global">
      <div class="sidebar-conteiner">
        <?php
          $urlIndex = '../../index.php';
          // Rendimiento
          $urlMisTareas = '../../rendimiento/v_tarea.php';
          $urlConsultarTareas = '../DataTableTarea/gestionDataTableTarea.php';
          $urlBitacoraTarea = ''; //PENDIENTE
          $urlMetricas = '../Metricas/gestionMetricas.php';
          $urlEstadisticas = '../../grafica/estadistica.php'; 
          //Solicitud
          $urlSolicitud = '../DataTableSolicitud/gestionDataTableSolicitud.php';
          //Comisión
          $urlComision = '../../comisiones/v_comision.php';
          //Consulta
          $urlClientes = '../cliente/gestionCliente.php';
          $urlVentas = '../Venta/gestionVenta.php';
          $urlArticulos = '../articulo/gestionArticulo.php';
          $urlObjetos = '../DataTableObjeto/gestionDataTableObjeto.php';
          $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
          //Mantenimiento
          $urlUsuarios = './gestionUsuario.php';
          $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
          $urlPreguntas = '../pregunta/gestionPregunta.php';
          $urlParametros = '../parametro/gestionParametro.php';
          $urlPermisos = '../permiso/gestionPermiso.php';
          $urlRoles = '../rol/gestionRol.php';
          $urlPorcentajes = '../Porcentajes/gestionPorcentajes.php';
          $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
          $urlPerfilUsuarios='../PerfilUsuario/gestionPerfilUsuario.php';
          $urlPerfilContraseniaUsuarios='../PerfilUsuario/gestionPerfilContrasenia.php';
          $urlEditarCamposPerfil='../PerfilUsuario/EditarCamposPerfilUsuario.php';
          $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
          require_once '../../layout/sidebar.php';
        ?>
      </div>
      <div class="conteiner-main">
      <div class="navbar-conteiner">
        <!-- Aqui va la barra -->
        <?php include_once '../../layout/navbar.php'?>
      </div>
      <!-- Cuerpo de la pagina -->
      <div class="container">
      <div class="title-form">
                <div class="img-content">
                  <img class="img" src="https://cdn-icons-png.flaticon.com/128/7563/7563276.png" height="50px">
             </div>
                <h2 class="text-title-form">Editar Perfil</h2>
            </div>
         <form  action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>"  method="post" id="form-Edit-PerfilUsuario"> 
              
            <div class="grupo-form">
              <div class="mb-3">
                    <label for="nombre">Usuario:</label>
                    <input type="text" class="form-control" name="usuario"   id="E_usuario" value="<?php echo $_SESSION['usuario'] ?>" disabled>
                    <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                    <label for="nombre">Rol:</label>
                    <input type="text" class="form-control" name="idRol"   id="E_idRol" value="<?php echo $data['rol_name'] ?>" disabled>
                    <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" name="nombre"   id="E_nombre"  value="<?php echo $data['nombre'] ?>" >
                    <p class="mensaje"></p>
              </div>
              <div class="mb-3">
                    <label for="nombre">RTN:</label>
                    <input type="text" class="form-control" name="rtn"   id="E_rtn"  value="<?php echo $data['rtn'] ?>" >
                    <p class="mensaje"></p>
              </div>
              
              
            </div>
            <div class="grupo-form" >
              
                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="E_email" value="<?php echo $data['correo'] ?>">
                    <p class="mensaje"></p>
                  </div>
                  <div class="mb-3">
                    <label for="telefono">Teléfono:</label>
                    <input type="tex" class="form-control" name="telefono"  id="E_telefono" value="<?php echo $data['telefono'] ?>">
                    <p class="mensaje"></p>
                </div>
                <div class="mb-3">
                      <label for="nombre">Dirección:</label>
                      <input type="text" class="form-control" name="direccion"   id="E_direccion"  value="<?php echo $data['direccion'] ?>" >
                      <p class="mensaje"></p>
                </div>
                  <div class="btn-guardar">
                        <button type="button"  class="btn btn-uno" ><a class=" btn-uno"  href="gestionPerfilUsuario.php"  >Cancelar</a></button>
                        <button type="submit" name="guardar" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                   </div>
            </div>
            
            </form>
            </div>
            <div class="container">
      <div class="title-form">
                <div class="img-content">
                  <img class="img" src="https://cdn-icons-png.flaticon.com/128/7887/7887104.png" height="50px">
             </div>
                <h2 class="text-title-form">Editar Preguntas Del Usuario</h2>
            </div>
         <form  action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>"  method="post" id="form-Edit-Preguntas"> 
          
                  <div class="mb-3">
                  <label  for="preguntas">Preguntas:</label>
                  <?php
                    $preguntasArray = $preguntas['preguntas'];
                    $respuestasArray = $preguntas['respuestas'];
                    $totalPreguntas = count($preguntasArray);

                    for ($i = 0; $i < $totalPreguntas; $i++) {
                        $respuesta = $i; // El índice se utilizará como respuesta
                        $pregunta = $preguntasArray[$i];
                        $respuestaName = "respuestas $respuesta";
                        $respuestaId = "E_respuestas $respuesta";
                        $valorRespuesta = isset($respuestasArray[$respuesta]) ? $respuestasArray[$respuesta] : '';
                    ?>
                    <br>
                    <label><?php echo $pregunta; ?></label>
                    <input type="text" class="form-control" name="respuestas" <?php echo $respuestaName; ?> id="<?php echo $respuestaId; ?>" value="<?php echo $valorRespuesta; ?>">
                    <?php
                      }
                    ?>
                    <p class="mensaje"></p>
                  </div>
                  <div class="btn-guardar">
                        <button type="button"  class="btn btn-uno" ><a class=" btn-uno"  href="gestionPerfilUsuario.php"  >Cancelar</a></button>
                        <button type="submit" name="guardarRespuestas" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                   </div>
            </div>
            
            </form>
           
      <!-- Footer -->
      <div class="footer-conteiner">
                <?php
                require_once '../../layout/footer.php';
                ?>
          </div>
        </div>
    </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <!-- Scripts propios -->
 
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
 <!-- <script src="../../../Recursos/js/PerfilUsuario/validacionesPerfilUsuario.js" type="module"></script> -->
</body>

</html>