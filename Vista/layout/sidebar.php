<nav class="sidebar locked">
  <!-- Logo del siberbar -->
  <div class="logo_items flex-log">
    <span class="nav_image">
      <a href="<?php echo $urlIndex; ?>">
        <img src="../../Recursos/imagenes/Logo-E&C.png" alt="logo_img" height="80px">
      </a>
    </span>
  </div>
  <div class="flex-log">
    <a href="<?php echo $urlIndex; ?>" style="text-decoration: none;">
      <span class="logo_name" >Cocinas&Equipos</span>
    </a>
  </div>
  <span class="flex-log">
    <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
    <i class="bx bx-x" id="sidebar-close"></i>
  </span>
  <!-- Contenedor principal del menu sidebar -->
  <div class="menu_container">
    <!-- Titulo general modulo -->
    <div class="">
      <span class="title__module">Modúlos</span>
      <span class="line"></span>
    </div>
    <!-- Lista de menus del sistema -->
    <ul class="conteiner__menu-principal">
      <!-- Lista rendimiento -->
      <li class=""> 
        <span>Rendimiento</span>
        <ul class="conteiner__menu-secundario">
          <li class="item-rendimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Mis Tareas</span>
            </a>
          </li>
          <li class="item-rendimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Consultar Tareas</span>
            </a>
          </li>
          <li class="item-rendimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Bitácora Tarea</span>
            </a>
          </li>
          <li class="item-rendimiento">
            <a href="<?php echo $urlMetricas; ?>" class="">
              <i class=""></i>
              <span>Metrícas</span>
            </a>
          </li>
          <li class="item-rendimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Estadísticas</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- Solicitud -->
      <li class="">
        <a href="<?php echo $urlSolicitud; ?>" class="">
          <i class=""></i>
          <span>Solicitud</span>
        </a>
      </li>
      <!-- Comision -->
      <li class="">
        <a href="<?php echo $urlComision; ?>" class="">
          <i class=""></i>
          <span>Comisión</span>
        </a>
      </li>
      <!-- Consulta -->
      <li class="">
        <span>Consulta</span>
        <ul class=conteiner__menu-secundario">
          <li class="item-consulta">
            <a href="<?php echo $urlCliente; ?>" class="">
              <i class=""></i>
              <span>Clientes</span>
            </a>
          </li>
          <li class="item-consulta">
            <a href="<?php echo $urlVenta; ?>" class="">
              <i class=""></i>
              <span>Ventas</span>
            </a>
          </li>
          <li class="item-consulta">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Artículo</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- Mantenimiento -->
      <li class="">
        <span>Mantenimiento</span>
        <ul class="conteiner__menu-secundario">
          <li class="item-mantenimiento">
            <a href="<?php echo $urlGestion; ?>" class="">
              <i class=""></i>
              <span>Usuarios</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Estado Usuario</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlCarteraCliente; ?>" class="">
              <i class=""></i>
              <span>Cartera Cliente</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlPreguntas; ?>" class="">
              <i class=""></i>
              <span>Preguntas</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlBitacoras; ?>" class="">
              <i class=""></i>
              <span>Bitácora Sistema</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Parámetros</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Permisos</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlRoles; ?>" class="">
              <i class=""></i>
              <span>Roles</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlPorcentaje; ?>" class="">
              <i class=""></i>
              <span>Porcentajes</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="">
              <i class=""></i>
              <span>Servicios Técnicos</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>