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
      <span class="logo_name">Cocinas&Equipos</span>
    </a>
  </div>
  <span class="flex-log">
    <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
    <i class="bx bx-x" id="sidebar-close"></i>
  </span>
  <!-- Contenedor principal del menu sidebar -->
  <div class="menu__container">
    <!-- Titulo general modulo -->
    <div class="title-conteiner">
      <span class="title__module">Modúlos</span>
      <span class="line"></span>
    </div>
    <!-- Lista de menus del sistema -->
    <ul class="dropdown-menu__content">
      <!-- Lista rendimiento -->
      <li class="dropdown-menu__content__list">
        <span class="check__conteiner">Rendimiento
          <input type="checkbox" class="dropdown-menu__content__list__check">
        </span>

        <div class="dropdown__content">
          <ul class="dropdown-menu__content__secundario">
            <li class="dropdown__list dropdown-menu__content__list__item">
              <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Mis Tareas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Consultar Tareas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Bitácora Tarea</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlMetricas; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Metrícas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Estadísticas</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- Solicitud -->
      <li class="dropdown-menu__content__list">
        <a href="<?php echo $urlSolicitud; ?>" class="dropdown__link">
          <i class=""></i>
          <span class="dropdown__link__span">Solicitud</span>
        </a>
      </li>
      <!-- Comision -->
      <li class="dropdown-menu__content__list">
        <a href="<?php echo $urlComision; ?>" class="dropdown__link">
          <i class=""></i>
          <span class="dropdown__link__span">Comisión</span>
        </a>
      </li>
      <!-- Consulta -->
      <li class="dropdown-menu__content__list">
        <span>Consulta</span>
        <ul class="dropdown-menu__content__secundario">
          <li class="dropdown-menu__content__list__item">
            <a href="<?php echo $urlCliente; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Clientes</span>
            </a>
          </li>
          <li class="dropdown-menu__content__list__item">
            <a href="<?php echo $urlVenta; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Ventas</span>
            </a>
          </li>
          <li class="dropdown-menu__content__list__item">
            <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Artículo</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- Mantenimiento -->
      <li class="dropdown-menu__content__list">
        <span>Mantenimiento</span>
        <ul class="dropdown-menu__content__secundario">
          <li class="item-mantenimiento">
            <a href="<?php echo $urlGestion; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Usuarios</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Estado Usuario</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlCarteraCliente; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Cartera Cliente</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlPreguntas; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Preguntas</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlBitacoras; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Bitácora Sistema</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Parámetros</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Permisos</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlRoles; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Roles</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlPorcentaje; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Porcentajes</span>
            </a>
          </li>
          <li class="item-mantenimiento">
            <a href="<?php echo $urlTarea; ?>" class="dropdown-menu__content__secundario__link">
              <i class=""></i>
              <span>Servicios Técnicos</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>