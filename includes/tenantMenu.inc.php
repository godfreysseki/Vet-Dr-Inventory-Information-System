<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="./" class="brand-link">
    <img src="../assets/img/logo.png" alt="<?= COMPANY ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= COMPANY ?></span>
  </a>
  
  <!-- Sidebar -->
  <div class="sidebar">
    
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
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
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
        
        <li class="nav-item">
          <a href="./" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="animals.php" class="nav-link">
            <i class="nav-icon fas fa-paw"></i>
            <p>
              Animals
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="clients.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Clients
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="appointments.php" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Appointments
              <span class="right badge badge-info">20</span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="medical_records.php" class="nav-link">
            <i class="nav-icon fas fa-file-medical"></i>
            <p>
              Medical Records
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="inventory.php" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>
              Inventory
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="expenses.php" class="nav-link">
            <i class="nav-icon fas fa-money-bill"></i>
            <p>
              Expenses
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="sales.php" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Sales
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="messages.php" class="nav-link">
            <i class="nav-icon fas fa-comments"></i>
            <p>
              Messages
              <span class="right badge badge-info messageCount">3</span>
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>