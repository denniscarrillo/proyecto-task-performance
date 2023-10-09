<nav class="navbar">
  <div class="navbar-content">
    <div class="notifations-conteiner">
    <p>Notificaciones</p><span class="notification-conteiner"><i class="notification-icon fa-solid fa-bell"></i></span> 
    </div>
    <div class="profile-conteiner">
        <title>Menú Dropdown</title>
        </head>
            <nav class="nav">
               
                <div class="nav__container">
                    <div class="notifations-conteiner">
                        <p><?php echo $_SESSION['usuario']; ?></p><span class="notification-conteiner"></span> 
                    </div>
                    <a href="#menu" class="nav__menu">
                    <span class="notification-conteiner"><i class="nb fa-solid fa-circle-user"></i></span>
                    </a>
                    <a href="#" class="nav__menu nav__menu--second">
                    <span class="notification-conteiner"><i class="nb fa-solid fa-circle-user"></i></span>
                    </a>
                    <ul class="dropdown" id="menu" >
                           <span class="dropdown__span">Configuracion de Perfil</span>
                            <div class="dropdow-divider" role="presentation">
                            
                            </div>
                            
                        <li class="dropdown__list">
                            
                                <a href="<?php echo $urlPerfilUsuario ?>"  class="dropdownlink"><i class="icon fa-solid fa-gears"></i class="notification-conteiner" >Personalizar Perfil</a>
                        </li>
                        <li class="dropdown__list">
                           
                                <a href="<?php echo  $urlPerfilContraseniaUsuarios ?>"  class="dropdownlink"><i class="icon type-lock fa-solid fa-lock"></i class="notification-conteiner">Seguridad y Contraseña</a>
                            
                        </li>
                        <li class="dropdown_list">
                              <a class="btn_Cerrar" href="../../db/logout.php">Salir</a>
                            
                        </li>
                    
                    </ul>

                </div>

            </div> 
          </div>
  </nav>