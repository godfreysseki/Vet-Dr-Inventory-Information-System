<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
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
		      <a href="blogs.php" class="nav-link">
			      <i class="nav-icon fas fa-clipboard"></i>
			      <p>
				      Blogs
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
		      <a href="contacts.php" class="nav-link">
			      <i class="nav-icon fas fa-phone"></i>
			      <p>
				      Contacts
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="appointments.php" class="nav-link">
			      <i class="nav-icon fas fa-calendar-alt"></i>
			      <p>
				      Appointments
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
				      Inventory & Stock
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="events.php" class="nav-link">
			      <i class="nav-icon fas fa-calendar-check"></i>
			      <p>
				      Events
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
		      <a href="online_orders.php" class="nav-link">
			      <i class="nav-icon fas fa-hand-lizard"></i>
			      <p>
				      Online Orders
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="resources.php" class="nav-link">
			      <i class="nav-icon fas fa-tree"></i>
			      <p>
				      Resources
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="sales_orders.php" class="nav-link">
			      <i class="nav-icon fas fa-shopping-cart"></i>
			      <p>
				      Sales Orders
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="stock_movement.php" class="nav-link">
			      <i class="nav-icon fas fa-balance-scale"></i>
			      <p>
				      Stock Movement
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="payroll.php" class="nav-link">
			      <i class="nav-icon fas fa-credit-card"></i>
			      <p>
				      Payroll Management
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="products.php" class="nav-link">
			      <i class="nav-icon fas fa-box-open"></i>
			      <p>
				      Products & Items
			      </p>
		      </a>
	      </li>
	      <li class="nav-item" data-toggle="tooltip" title="Earnings and Expenses Plus Money at the end of the Day.">
		      <a href="profit_management.php" class="nav-link">
			      <i class="nav-icon fas fa-chart-line"></i>
			      <p>
				      Profit Management
			      </p>
		      </a>
	      </li>
	      <li class="nav-item">
		      <a href="javascript:void(0)" class="nav-link">
			      <i class="nav-icon fas fa-print"></i>
			      <p>
				      Reports
				      <i class="right fas fa-angle-left"></i>
			      </p>
		      </a>
		      <ul class="nav nav-treeview">
			      <li class="nav-item">
				      <a href="reports_expenses.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>Expenses Report</p>
				      </a>
			      </li>
			      <li class="nav-item">
				      <a href="reports_inventory.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>Inventory Report</p>
				      </a>
			      </li>
			      <li class="nav-item">
				      <a href="reports_payroll.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>Payroll Report</p>
				      </a>
			      </li>
			      <li class="nav-item">
				      <a href="reports_profit.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>Profit Report</p>
				      </a>
			      </li>
			      <li class="nav-item">
				      <a href="reports_sales.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>Sales Report</p>
				      </a>
			      </li>
		      </ul>
	      </li>
        <li class="nav-item">
          <a href="users.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users Management
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="settings.php" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Settings Management
            </p>
          </a>
        </li>
	      <li class="nav-item">
		      <a href="javascript:void(0)" class="nav-link">
			      <i class="nav-icon fas fa-database"></i>
			      <p>
				      System Management
				      <i class="right fas fa-angle-left"></i>
			      </p>
		      </a>
		      <ul class="nav nav-treeview">
			      <li class="nav-item">
				      <a href="system.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>System Backup</p>
				      </a>
			      </li>
			      <li class="nav-item">
				      <a href="system_audit_trails.php" class="nav-link">
					      <i class="far fa-circle nav-icon"></i>
					      <p>User Audit Trails</p>
				      </a>
			      </li>
		      </ul>
	      </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>