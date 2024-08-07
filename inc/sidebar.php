  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="img/Logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-2" style="opacity: .8">
      <span class="brand-text font-weight-light">IoT Platform</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['fullname'] ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
              <?php if ($_SESSION['role'] == "Adm") { ?>     
                    <li class="nav-item">
                      <a href="?page=user" class="nav-link">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>User Data
                        <span class="right badge badge-danger">Admin Only</span>
                        </p>
                      </a>
                    </li>
              <?php } ?>  
                    <li class="nav-item">
                      <a href="?page=mqtt" class="nav-link">
                        <i class="fab fa-mixcloud"></i>
                        <p>Testing MQTT </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?page=http" class="nav-link">
                        <i class="fas fa-server"></i>
                        <p>Testing HTTP </p>
                      </a>
                    </li>   
                    <li class="nav-item">
                      <a href="?page=kontrol" class="nav-link">
                        <i class="fas fa-server"></i>
                        <p>Testing Kontrol Output </p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="?page=lorahttp" class="nav-link">
                        <i class="fas fa-server"></i>
                        <p>Testing Receiving Lora HTTP</p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="?page=lora" class="nav-link">
                        <i class="fas fa-server"></i>
                        <p>Testing Receiving Lora MQTT</p>
                      </a>
                    </li>         
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Jobsheet
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../../index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 1</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../../index2.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 2</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../../index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 3</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../../index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 4</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../../index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 5</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../../index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 6</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../../index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jobsheet 7</p>
                      </a>
                    </li>
                  </ul>
                    </li>
                    <li class="nav-item">
                      <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                      </a>
                </li>
          </ul>
        </nav>>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>