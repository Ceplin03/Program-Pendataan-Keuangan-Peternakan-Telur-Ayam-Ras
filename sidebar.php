<aside class="main-sidebar sidebar-dark-primary elevation-4">
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="#" class="d-block"><h4><?php echo $_SESSION['username']; ?></h4></a>
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
            <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <?php if ($_SESSION['username'] == 'admin'): ?>
         
            <li class="nav-item">
            <a href="user.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User
                
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="produksi.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Produksi
                
              </p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="l_penjualan.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Penjualan
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="l_pengeluaran.php" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Pengeluaran
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="l_pendapatan.php" class="nav-link">
              <i class="nav-icon fas fa-book mr-1"></i>
              <p>
                Pendapatan
                
              </p>
            </a>
          </li>

          <li class="nav-item menu-close">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Laporan Data Keuangan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="laporan_bulanan.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Bulanan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="laporan_tahunan.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Tahunan</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['username'] == 'karyawan'): ?>

            <li class="nav-item">
            <a href="penjualan.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Penjualan
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="pengeluaran.php" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Pengeluaran
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="pendapatan.php" class="nav-link">
              <i class="nav-icon fas fa-book mr-1"></i>
              <p>
                Pendapatan
                
              </p>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-link mr-1"></i>
              <p>
                Logout
                
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>