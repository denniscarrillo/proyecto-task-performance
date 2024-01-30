<?php
require_once(__DIR__ . '/../../db/Conexion.php');
require_once(__DIR__ . '/../../Modelo/Parametro.php');
require_once(__DIR__ . '/../../Controlador/ControladorParametro.php');

// Resto de tu código ...

// Obtener los parámetros del footer
$footerDatos = ControladorParametro::obteniendoFooter();
foreach($footerDatos as $datos){
  $tienda = $datos['tiendaOnline'];
  $correo = $datos['correoElectronico'];
  $facebook = $datos['facebookLink'];
  $telefono = $datos['telefonoEmpresa'];
}

?>
<footer class="footer-content">
  <a href="<?php echo $tienda; ?>" class="footer-link">
    <i class="fa-solid fa-globe footer-icon"></i>
    <p>Tienda Online</p>
  </a>
  <a href="mailto:<?php echo $correo; ?>" class="footer-link">
    <i class="fa-solid fa-envelope-open-text footer-icon"></i>
    <p>Correo Electrónico</p>
  </a>
  <a href="<?php echo $facebook; ?>" class="footer-link">
    <i class="fa-brands fa-facebook footer-icon"></i>
    <p>Facebook</p>
  </a>
  <span class="footer-link">
    <i class="fa-solid fa-square-phone footer-icon"></i>
    <p><?php echo $telefono; ?></p>
  </span>
</footer>

