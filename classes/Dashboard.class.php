<?php
  
  class Dashboard extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function totalSales($user_id = null)
    {
      if ($user_id !== null) {
        $sql    = "SELECT SUM(sale_amount) AS num FROM sales WHERE sale_date LIKE '" . date('Y-m-d', $_SERVER['REQUEST_TIME']) . "%' && user_id=?";
        $params = [$user_id];
        $result = $this->selectQuery($sql, $params)->fetch_assoc();
      } else {
        $sql    = "SELECT SUM(sale_amount) AS num FROM sales WHERE sale_date LIKE '" . date('Y-m-d', $_SERVER['REQUEST_TIME']) . "%' ";
        $result = $this->selectQuery($sql)->fetch_assoc();
      }
      return $result['num'] ?? 0;
    }
    
    public function newAppointments()
    {
      $sql    = "SELECT COUNT(appointment_id) AS num FROM appointments WHERE status='Pending' ";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['num'] ?? 0;
    }
    
    public function totalExpenses($user_id = null)
    {
      if ($user_id !== null) {
        $sql    = "select sum(amount) as num from expenses WHERE expense_date LIKE '" . date('Y-m-d', $_SERVER['REQUEST_TIME']) . "%' && user_id=? ";
        $params = [$user_id];
        $result = $this->selectQuery($sql, $params)->fetch_assoc();
      } else {
        $sql    = "select sum(amount) as num from expenses WHERE expense_date LIKE '" . date('Y-m-d', $_SERVER['REQUEST_TIME']) . "%' ";
        $result = $this->selectQuery($sql)->fetch_assoc();
      }
      return $result['num'] ?? 0;
    }
    
    public function overallSales()
    {
      $sql    = "SELECT SUM(sale_amount) AS num FROM sales";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['num'] ?? 0;
    }
    
    public function overallExpenses()
    {
      // Total cost over time
      $sql    = "SELECT SUM(amount) AS num FROM expenses";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['num'] ?? 0;
    }
  
    public function overallAnimalsTreated()
    {
      // Total animals treated over time
      $sql    = "SELECT COUNT(record_id) AS num FROM medical_records GROUP BY animal_id";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['num'] ?? 0;
    }
    
    // stock levels monitor
    public function displayLowStockProducts()
    {
      // Define the SQL query to select products with quantities equal to or below the reorder level
      $sql = "SELECT * FROM products WHERE quantity_in_stock < reorder_level";
    
      // Execute the query
      $result = $this->selectQuery($sql);
    $no = 1;
      // Initialize an empty string to store the HTML table markup
      $tableHtml = '<div class="table-responsive">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Qty Left</th>
                            </tr>
                        </thead>
                        <tbody>';
    
      // Fetch each row from the result and append it to the table HTML
      while ($row = $result->fetch_assoc()) {
        $tableHtml .= '<tr>';
        $tableHtml .= '<td>' . $no . '</td>';
        $tableHtml .= '<td>' . $row['product_name'] . '</td>';
        $tableHtml .= '<td>' . $row['quantity_in_stock'] . '</td>';
        $tableHtml .= '</tr>';
        $no++;
      }
    
      // Close the table HTML
      $tableHtml .= '</tbody></table></div>';
    
      // Return the HTML table markup
      return $tableHtml;
    }
  
    // Monthly data for caret management and percentage of gain
    public function caretFormer($last, $now)
    {
      $now  = ($now <= 0) ? 1 : $now;
      $data = '';
      if ($last === $now) {
        $perc = 0;
        $data = '<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> ' . abs($perc) . '%</span>';
      } elseif ($last > $now) {
        $perc = ($last !== 0) ? round((($now - $last) / abs($last)) * 100) : 0;
        $data = '<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> ' . abs($perc) . '%</span>';
      } elseif ($last < $now && $last > 0) {
        $perc = ($last !== 0) ? round((($now - $last) / abs($last)) * 100) : 0;
        $data = '<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> ' . $perc . '%</span>';
      } else {
        $perc = 100;
        $data = '<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> ' . abs($perc) . '%</span>';
      }
      
      return $data;
    }
    
    public function realSales()
    {
      // Last Month
      $lastMonth = date("Y-m", strtotime("-1 month", $_SERVER['REQUEST_TIME']));
      $sqlLast   = "SELECT IFNULL(SUM(sale_amount), 0) as lastSales FROM sales WHERE sale_date LIKE '" . $lastMonth . "%'";
      $rowLast   = $this->selectQuery($sqlLast)->fetch_assoc();
      
      // This Month
      $thisMonth = date("Y-m", $_SERVER['REQUEST_TIME']);
      $sqlNow    = "SELECT IFNULL(SUM(sale_amount), 0) as nowSales FROM sales WHERE sale_date LIKE '" . $thisMonth . "%'";
      $rowNow    = $this->selectQuery($sqlNow)->fetch_assoc();
      
      $last = $rowLast['lastSales'];
      $now  = $rowNow['nowSales'];
      
      return $this->caretFormer($last, $now);
    }
    
    public function realExpenses()
    {
      // Last Month
      $lastMonth = date("Y-m", strtotime("-1 month", $_SERVER['REQUEST_TIME']));
      $sqlLast   = "SELECT IFNULL(SUM(amount), 0) as lastSales FROM expenses WHERE expense_date LIKE '" . $lastMonth . "%' ";
      $rowLast   = $this->selectQuery($sqlLast)->fetch_assoc();
      // This Month
      $thisMonth = date("Y-m", $_SERVER['REQUEST_TIME']);
      $sqlNow    = "SELECT IFNULL(SUM(amount), 0) as nowSales FROM expenses WHERE expense_date LIKE '" . $thisMonth . "%' ";
      $rowNow    = $this->selectQuery($sqlNow)->fetch_assoc();
      
      $last = $rowLast['lastSales'];
      $now  = $rowNow['nowSales'];
      
      return $this->caretFormer($last, $now);
    }
    
    public function realProfit()
    {
      
      // Last Month Revenue
      $lastMonth      = date("Y-m", strtotime("-1 month", $_SERVER['REQUEST_TIME']));
      $sqlLastRevenue = "SELECT IFNULL(SUM(sale_amount), 0) as lastSales FROm sales WHERE sale_date LIKE '" . $lastMonth . "%' ";
      $rowLastRevenue = $this->selectQuery($sqlLastRevenue)->fetch_assoc();
      // This Month
      $thisMonth     = date("Y-m", $_SERVER['REQUEST_TIME']);
      $sqlNowRevenue = "SELECT IFNULL(SUM(sale_amount), 0) as nowSales FROM sales WHERe sale_date LIKE '" . $thisMonth . "%' ";
      $rowNowRevenue = $this->selectQuery($sqlNowRevenue)->fetch_assoc();
      
      $lastRevenue = $rowLastRevenue['lastSales'];
      $nowRevenue  = $rowNowRevenue['nowSales'];
      // Last Month Expenses
      $sqlLast = "SELECT SUM(amount) as lastSales FROM expenses WHERE expense_date LIKE '" . date("Y-m", strtotime("-1 month", $_SERVER['REQUEST_TIME'])) . "%' ";
      $rowLast = $this->selectQuery($sqlLast)->fetch_assoc();
      // This Month
      $sqlNow = "SELECT SUM(amount) as nowSales FROM expenses WHERE expense_date LIKE '" . date("Y-m", $_SERVER['REQUEST_TIME']) . "%' ";
      $rowNow = $this->selectQuery($sqlNow)->fetch_assoc();
      
      $last = $rowLast['lastSales'];
      $now  = $rowNow['nowSales'];
      
      return $this->caretFormer(abs($lastRevenue - $last), abs($nowRevenue - $now));
    }
  
    public function realAnimalsTreated()
    {
      // Last Month
      $lastMonth = date("Y-m", strtotime("-1 month", $_SERVER['REQUEST_TIME']));
      $sqlLast   = "SELECT IFNULL(SUM(amount), 0) as lastSales FROM expenses WHERE expense_date LIKE '" . $lastMonth . "%' ";
      $rowLast   = $this->selectQuery($sqlLast)->fetch_assoc();
      // This Month
      $thisMonth = date("Y-m", $_SERVER['REQUEST_TIME']);
      $sqlNow    = "SELECT IFNULL(SUM(amount), 0) as nowSales FROM expenses WHERE expense_date LIKE '" . $thisMonth . "%' ";
      $rowNow    = $this->selectQuery($sqlNow)->fetch_assoc();
    
      $last = $rowLast['lastSales'];
      $now  = $rowNow['nowSales'];
    
      return $this->caretFormer($last, $now);
    }
    
    /******
     * CHARTS
     */
    
    public function getRealTimeSalesData()
    {
      // Perform database query to fetch real-time sales data
      // Ensure you format the data as an array, e.g., ['timestamp' => '2023-08-01 12:00:00', 'sales' => 100]
      if ($_SESSION['role'] === 'tenant') {
        $sql = "SELECT sum(sale_amount) as sale_amounts, MONTHNAME(sale_date) as months, MONTH(sale_date) as monthss, sum(amount) as amounts FROM expenses, sales WHERE sale_date LIKE '" . date('Y',
            $_SERVER['REQUEST_TIME']) . "%' && (sales.user_id=? || expenses.user_id=?) && expense_date LIKE '" . date('Y', $_SERVER['REQUEST_TIME']) . "%' && sale_date <= (NOW() - INTERVAL 1 HOUR) GROUP BY months ORDER BY monthss ASC";
        $params = [$_SESSION['user_id'], $_SESSION['user_id']];
        $result = $this->selectQuery($sql, $params);
      } else {
        $sql = "SELECT sum(sale_amount) as sale_amounts, MONTHNAME(sale_date) as months, MONTH(sale_date) as monthss, sum(amount) as amounts FROM expenses, sales WHERE sale_date LIKE '" . date('Y',
            $_SERVER['REQUEST_TIME']) . "%' && expense_date LIKE '" . date('Y', $_SERVER['REQUEST_TIME']) . "%' && sale_date <= (NOW() - INTERVAL 1 HOUR) GROUP BY months ORDER BY monthss ASC";
        $result = $this->selectQuery($sql);
      }
      
      $salesData = [];
      while ($row = $result->fetch_assoc()) {
        $salesData[] = ['timestamp' => $row['months'], 'sales' => ($row['sale_amounts'] / 2), 'costs' => ($row['amounts'] / 2)];
      }
      
      return $salesData;
    }
    
    
  }