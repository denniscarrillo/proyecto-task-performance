<nav class="sidebar locked">
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
  <div class="menu_container">
    <div class="menu_items">
      <ul class="menu_item">
        <div class="menu_title flex align">
          <span class="title">Modúlos</span>
          <span class="line"></span>
        </div>
        <li class="item">
          <a href="<?php echo $urlTarea; ?>" class="link flex">
            <i class='bx bx-task'></i>
            <span>Rendimiento</span>
          </a>
        </li>
        <li class="item">
          <a href="<?php echo $urlSolicitud; ?>" class="link flex">
            <i class='bx bx-store-alt'></i>
            <span>Solicitud</span>
          </a>
        </li>
        <li class="item">
          <a href="<?php echo $urlComision; ?>" class="link flex">
            <i class='bx bx-store-alt'></i>
            <span>Comisión</span>
          </a>
        </li>
      </ul>
      <ul class="menu_item">
        <div class="menu_title flex">
          <span class="title">Consulta</span>
          <span class="line"></span>
        </div>
        <li class="item">
          <a href="<?php echo $urlVenta ; ?>" class="link flex">
            <i class="bx bxs-magic-wand"></i>
            <span>Ventas</span>
          </a>
        </li>
        <li class="item">
          <a href="<?php echo $urlCliente; ?>" class="link flex">
            <i class="bx bx-folder"></i>
            <span>Clientes</span>
          </a>
        </li>
        <li class="item">
          <a href="<?php echo $urlCarteraCliente; ?>" class="link flex">
            <i class="bx bx-folder"></i>
            <span>Cartera clientes</span>
          </a>
        </li>
      </ul>
      <ul class="menu_item">
        <div class="menu_title flex">
          <span class="title">Mantenimiento</span>
          <span class="line"></span>
        </div>
        <li class="item">
          <a href="<?php echo $urlGestion; ?>" class="link flex">
            <i class='bx bxs-user-badge'></i>
            <span>Usuarios</span>
          </a>
        </li>
        <li class="item">
          <a href="<?php echo$urlCrudComision; ?>" class="link flex">
            <i class='bx bxs-user-badge'></i>
            <span>Comisiones</span>
          </a>
        </li>
        <!-- <li class="item">
          <a href="" class="link flex">
            <i class='bx bxs-user-badge'></i>
            <span>Settings</span>
          </a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>