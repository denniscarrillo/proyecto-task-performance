<nav id="sidebar-id" class="class">
  <!-- Logo del siberbar -->
  <div class="logo_items flex-log">
    <span class="nav_image">
      <a href="<?php echo $urlIndex; ?>" style="height: 87px;">
        <img src="<?php echo $urlImg; ?>" alt="logo_img" height="80px">
      </a>
    </span>
  </div>
  <div class="flex-log system_name">
    <a href="<?php echo $urlIndex; ?>" style="text-decoration: none;">
      <!-- <span class="logo_name">Task Performance</span> -->
      <div style="display: flex; justify-content: center;">
        <p
          style="display: flex; justify-content: center; font-size: 1rem; font-weight: 500; width: 200px; 
        margin-bottom: 0.5rem; color: black; text-transform: uppercase; background-color: #ffc90e; border-radius: 3rem;">
          Task
          Performance
        </p>
      </div>
    </a>
  </div>
  <!-- Contenedor principal del menu sidebar -->
  <div class="menu__container">
    <!-- Lista de menus del sistema -->
    <ul class="dropdown-menu__content">
      <!-- Lista rendimiento -->
      <li class="dropdown-menu__content__list">
        <span class="check__conteiner dropdown__link__span"
          id="<?php echo ControladorBitacora::obtenerIdObjeto('v_tarea.php'); ?>">
          <div class="icon-menu-principal__conteiner">
            <i class="icon-menu-principal fa-solid fa-square-poll-vertical"></i>
          </div>
          <p class="list__menu__principal-text">Rendimiento</p>
          <i class="dropdown__arrow fa-solid fa-angle-down"></i>
          <input type="checkbox" class="dropdown-menu__content__list__check">
        </span>
        <div class="dropdown__content">
          <ul class="dropdown-menu__content__secundario">
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlMisTareas; ?>" class="dropdown-menu__content__secundario__link">
                <span>Mis Tareas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlCotizacion; ?>" class="dropdown-menu__content__secundario__link">
                <span>Ver Cotizaciones</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlConsultarTareas; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Ver Tareas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlMetricas; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Metrícas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlEstadisticas; ?>" class="dropdown-menu__content__secundario__link">
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
          <span class="check__conteiner dropdown__link__span"
            id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionDataTableSolicitud.php'); ?>">
            <div class="icon-menu-principal__conteiner">
              <i class="icon-menu-principal fa-solid fa-envelopes-bulk icon-size"></i>
            </div>
            <p class="list__menu__principal-text">Solicitud</p>
          </span>
        </a>
      </li>
      <!-- Comision -->
      <li class="dropdown-menu__content__list">
        <i class=""></i>
        <span class="check__conteiner dropdown__link__span"
          id="<?php echo ControladorBitacora::obtenerIdObjeto('v_comision.php'); ?>">
          <div class="icon-menu-principal__conteiner">
            <i class="icon-menu-principal fa-solid fa-file-invoice-dollar icon-size"></i>
          </div>
          <p class="list__menu__principal-text">Comisión</p>
          <i class="dropdown__arrow fa-solid fa-angle-down"></i>
          <input type="checkbox" class="dropdown-menu__content__list__check">
        </span>
        <div class="dropdown__content">
          <ul class="dropdown-menu__content__secundario">
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlComision; ?>" class="dropdown-menu__content__secundario__link">
                <!-- <i class="fa-solid fa-list-check"></i> -->
                <span>Comisiones</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $comisionVendedor; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Total Vendedores</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlPorcentajes; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Porcentajes</span>
              </a>
            </li>
          </ul>
        </div>
        </a>
      </li>
      <!-- Consulta -->
      <li class="dropdown-menu__content__list">
        <span class="check__conteiner dropdown__link__span"
          id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionCliente.php'); ?>">
          <div class="icon-menu-principal__conteiner">
            <i class="icon-menu-principal fa-solid fa-magnifying-glass-arrow-right"></i>
          </div>
          <p class="list__menu__principal-text">Consulta</p>
          <i class="dropdown__arrow fa-solid fa-angle-down"></i>
          <input type="checkbox" class="dropdown-menu__content__list__check">
        </span>
        <div class="dropdown__content">
          <ul class="dropdown-menu__content__secundario">
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlBitacoraSistema; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Bitácora Sistema</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- Mantenimiento -->
      <li class="dropdown-menu__content__list">
        <span class="check__conteiner dropdown__link__span"
          id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionUsuario.php'); ?>">
          <div class="icon-menu-principal__conteiner">
            <i class="icon-menu-principal fa-solid fa-business-time"></i>
          </div>
          <p class="list__menu__principal-text">Mantenimiento</p>
          <i class="dropdown__arrow fa-solid fa-angle-down"></i>
          <input type="checkbox" class="dropdown-menu__content__list__check">
        </span>
        <div class="dropdown__content">
          <ul class="dropdown-menu__content__secundario">
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlUsuarios; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Usuarios</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlEstadoUsuario; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Estado Usuario</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlCarteraCliente; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Cartera Cliente</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlServiciosTecnicos; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Servicios Técnicos</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlRazonSocial; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Razón Social</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlRubroComercial; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Rubro Comercial</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlVentas; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Ventas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlArticulos; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Artículos</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- Seguridad -->
      <li class="dropdown-menu__content__list">
        <span class="check__conteiner dropdown__link__span"
          id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionCliente.php');?>">
          <div class="icon-menu-principal__conteiner">
            <i class="icon-menu-principal fa-solid fa-shield-halved"></i>
          </div>
          <p class="list__menu__principal-text">Seguridad</p>
          <i class="dropdown__arrow fa-solid fa-angle-down"></i>
          <input type="checkbox" class="dropdown-menu__content__list__check">
        </span>
        <div class="dropdown__content">
          <ul class="dropdown-menu__content__secundario">
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlPreguntas; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Preguntas</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlObjetos; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Objetos Sistema</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlParametros; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Parámetros</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlPermisos; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Permisos</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlRoles; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Roles</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlRoles; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Respaldo BD</span>
              </a>
            </li>
            <li class="dropdown-menu__content__list__item">
              <a href="<?php echo $urlRoles; ?>" class="dropdown-menu__content__secundario__link">
                <i class=""></i>
                <span>Restauración</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- Solicitud -->
        <li class="dropdown-menu__content__list">
          <a href="<?php echo $urlRestoreBackup; ?>" class="dropdown__link">
            <span class="check__conteiner dropdown__link__span"
              id="<?php echo ControladorBitacora::obtenerIdObjeto('gestionBackupRestore.php'); ?>">
              <div class="icon-menu-principal__conteiner">
                <i class="icon-menu-principal fa-solid fa-window-restore icon-size"></i>
              </div>
              <p class="list__menu__principal-text">Backup & Restore</p>
            </span>
          </a>
        </li>
      </li>
    </ul>
  </div>
</nav>