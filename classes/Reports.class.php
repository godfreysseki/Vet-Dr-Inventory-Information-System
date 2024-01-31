<?php
  
  
  class Reports extends Config
  {
    
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    // Expenses Report
    private function mostExpenditureItem($start_date, $end_date)
    {
      $data   = '';
      $sql    = "SELECT expense_name FROM expenses WHERE amount = (SELECT MAX(amount) FROM expenses WHERE expense_date >= ? AND expense_date <= ?)";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      if ($row) {
        $data = 'The most costly expense item was <b>' . $row['expense_name'] . '</b>';
      }
      return $data;
    }
    
    private function mostExpenditure($start_date, $end_date)
    {
      $data   = '';
      $sql    = "SELECT MAX(amount) AS amounts FROM expenses WHERE expense_date >= ? AND expense_date <= ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      if ($row) {
        $data = 'with an amount of <b>' . CURRENCY .' '. number_format($row['amounts'], 2) . '</b>';
      }
      return $data;
    }
    
    private function frequentExpenditureItem($start_date, $end_date)
    {
      $data   = '';
      $sql    = "SELECT expense_name FROM expenses WHERE amount = (SELECT MAX(amount) FROM expenses WHERE expense_date >= ? AND expense_date <= ?)";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      if ($row) {
        $data = 'The most frequent expense item was <b>' . $row['expense_name'] . '</b>';
      }
      return $data;
    }
    
    private function frequentExpenditureAmount($start_date, $end_date)
    {
      $data   = '';
      $sql    = "SELECT MAX(amount) AS amounts FROM expenses WHERE expense_date >= ? AND expense_date <= ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      if ($row) {
        $data = 'with a total amount of <b>' . CURRENCY . ' ' . number_format($row['amounts']) . '</b>';
      }
      return $data;
    }
    
    private function frequentExpenditureTimes($start_date, $end_date)
    {
      $data   = '';
      $sql    = "SELECT COUNT(*) AS frequency FROM expenses WHERE expense_date >= ? AND expense_date <= ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      if ($row) {
        $data = 'and it occurred ' . number_format($row['frequency']) . ' times';
      }
      return $data;
    }
    
    public function expensesReport($start_date, $end_date)
    {
      $data   = [];
      $report = 'No Report to generate for the selected date';
      $sql    = "SELECT SUM(amount) AS amounts, LEFT(expense_date, 7) AS dates FROM expenses WHERE expense_date>=? && expense_date<=? GROUP BY dates";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      // Get total expenses
      $totalAmount = 0;
      foreach ($data as $datum) {
        $totalAmount += $datum['amounts'];
      }
      // monthly expenses
      $months = '';
      foreach ($data as $datum) {
        $months .= '<tr>
                      <td>' . date('M, Y', strtotime($datum['dates'])) . '</td>
                      <td>' . number_format($datum['amounts'], 2) . '</td>
                    </tr>';
      }
      
      $report = '<p>
                    The total amount spent from <b>' . dates($start_date) . '</b> to <b>' . dates($end_date) . '</b> is <b>' . CURRENCY . ' ' . number_format($totalAmount, 2) . '.</b>
                    ' . $this->mostExpenditureItem($start_date, $end_date) . ' has been the most costly expenses ' . $this->mostExpenditure($start_date, $end_date) . ' and
                    ' . $this->frequentExpenditureItem($start_date, $end_date) . ' has been the most frequent expense with a total of ' . $this->frequentExpenditureAmount($start_date, $end_date) . ' ' . $this->frequentExpenditureTimes($start_date,
          $end_date) . '.
                 </p>';
      $report .= '<table class="table table-sm table-striped table-bordered">
                  <tr>
                    <th>MONTH</th>
                    <th>AMOUNT('. CURRENCY .')</th>
                  </tr>
                  ' . $months . '
                 </table>';
      return $report;
    }
    
    // Inventory Report
    public function totalItems($start_date, $end_date)
    {
      // Retrieve the total number of items purchased within the specified date range
      $sql    = "SELECT SUM(quantity) AS total_items FROM inventory WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      
      return ($row && $row['total_items'] !== null) ? $row['total_items'] : 0;
    }
    
    public function totalCostPrice($start_date, $end_date)
    {
      // Retrieve the total cost price of items purchased within the specified date range
      $sql    = "SELECT SUM(cost_price * quantity) AS total_cost_price FROM inventory WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      
      return ($row && $row['total_cost_price'] !== null) ? $row['total_cost_price'] : 0;
    }
    
    public function inventoryReport($start_date, $end_date)
    {
      $data = [];
      
      // Retrieve all inventory records within the specified date range
      $sql    = "SELECT * FROM inventory WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      
      // Check if there are any records
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      
      // Calculate total items and total cost price
      $totalItems     = $this->totalItems($start_date, $end_date);
      $totalCostPrice = $this->totalCostPrice($start_date, $end_date);
      
      // Prepare the report
      $report = '<p>Inventory Report for the period from <b>' . dates($start_date) . '</b> to <b>' . dates($end_date) . ':</b></p>';
      $report .= '<p>Total Item Quantities Purchased: <b>' . $totalItems . '</b></p>';
      $report .= '<p>Total Cost Price: <b>' . CURRENCY . ' ' . number_format($totalCostPrice, 2) . '</b></p>';
      
      // Display the table for all inventory records
      if (!empty($data)) {
        $report .= '<table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Cost Price(' . CURRENCY . ')</th>
                                    <th>Selling Price(' . CURRENCY . ')</th>
                                    <th>Total Cost(' . CURRENCY . ')</th>
                                    <th>Total Profit(' . CURRENCY . ')</th>
                                    <th>Inventory Date</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>';
        
        foreach ($data as $row) {
          $totalCost = $row['cost_price'] * $row['quantity'];
          
          $report .= '<tr>
                                <td>' . $row['item_id'] . '</td>
                                <td>' . $this->getItemName($row['item_name']) . '</td>
                                <td>' . $row['quantity'] . '</td>
                                <td>' . number_format($row['cost_price'], 2) . '</td>
                                <td>' . number_format($row['selling_price'], 2) . '</td>
                                <td>' . number_format($totalCost, 2) . '</td>
                                <td>' . number_format(((($row['selling_price'] - $row['cost_price']) * $row['quantity']) - $totalCost), 2) . '</td>
                                <td>' . datel($row['created_at']) . '</td>
                                <!-- Add more columns as needed -->
                            </tr>';
        }
        
        $report .= '</tbody></table>';
      } else {
        $report .= '<p>No inventory records found for the selected date range.</p>';
      }
      
      // Placeholder for additional information
      
      return $report;
    }
    
    // Payroll Report
    public function payrollReport($start_date, $end_date)
    {
      $data = [];
      
      // Retrieve total salary, deductions, bonuses, advanced payments, and balances
      $totalSalary           = $this->getTotalSalary($start_date, $end_date);
      $totalDeductions       = $this->getTotalDeductions($start_date, $end_date);
      $totalBonuses          = $this->getTotalBonuses($start_date, $end_date);
      $totalAdvancedPayments = $this->getTotalAdvancedPayments($start_date, $end_date);
      $totalBalances         = $this->getTotalBalances($start_date, $end_date);
      
      // Retrieve all payroll records within the specified date range
      $sql    = "SELECT * FROM payroll WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      
      // Check if there are any records
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      
      // Prepare the report
      $report = '<p>Total salary paid from <b>' . dates($start_date) . '</b> to <b>' . dates($end_date) . '</b> is <b>' . CURRENCY . ' ' . number_format($totalSalary, 2) . '</b>.</p>';
      $report .= '<p>Total deductions during this period is <b>' . CURRENCY . ' ' . number_format($totalDeductions, 2) . '</b>.</p>';
      $report .= '<p>Total bonuses paid during this period is <b>' . CURRENCY . ' ' . number_format($totalBonuses, 2) . '</b>.</p>';
      $report .= '<p>Total advanced payments made during this period is <b>' . CURRENCY . ' ' . number_format($totalAdvancedPayments, 2) . '</b>.</p>';
      $report .= '<p>Total balances remaining after payments is <b>' . CURRENCY . ' ' . number_format($totalBalances, 2) . '</b>.</p>';
      
      // Display the table for all payroll records
      if (!empty($data)) {
        $report .= '<table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Salary(' . CURRENCY . ')</th>
                                <th>Deductions(' . CURRENCY . ')</th>
                                <th>Bonuses(' . CURRENCY . ')</th>
                                <th>Advanced Payment(' . CURRENCY . ')</th>
                                <th>Total Payment(' . CURRENCY . ')</th>
                                <th>Balance(' . CURRENCY . ')</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        foreach ($data as $row) {
          $report .= '<tr>
                            <td>' . $this->getUserName($row['user_id']) . '</td>
                            <td>' . date('M', strtotime($row['month'])) . '</td>
                            <td>' . $row['year'] . '</td>
                            <td>' . number_format($row['salary'], 2) . '</td>
                            <td>' . number_format($row['deductions'], 2) . '</td>
                            <td>' . number_format($row['bonuses'], 2) . '</td>
                            <td>' . number_format($row['advanced_payment'], 2) . '</td>
                            <td>' . number_format($row['total_payment'], 2) . '</td>
                            <td>' . number_format($row['balance'], 2) . '</td>
                            <td>' . $row['payment_status'] . '</td>
                        </tr>';
        }
        
        $report .= '</tbody></table>';
      }
      
      return $report;
    }
    
    private function getTotalSalary($start_date, $end_date)
    {
      // Retrieve total salary from the database
      $sql    = "SELECT SUM(salary) AS total_salary FROM payroll WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      
      return ($row && $row['total_salary']) ? $row['total_salary'] : 0;
    }
    
    private function getTotalDeductions($start_date, $end_date)
    {
      $sql    = "SELECT SUM(deductions) AS total_deductions FROM payroll WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      return ($row['total_deductions'] !== null) ? $row['total_deductions'] : 0;
    }
    
    private function getTotalBonuses($start_date, $end_date)
    {
      $sql    = "SELECT SUM(bonuses) AS total_bonuses FROM payroll WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      return ($row['total_bonuses'] !== null) ? $row['total_bonuses'] : 0;
    }
    
    private function getTotalAdvancedPayments($start_date, $end_date)
    {
      $sql    = "SELECT SUM(advanced_payment) AS total_advanced_payments FROM payroll WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      return ($row['total_advanced_payments'] !== null) ? $row['total_advanced_payments'] : 0;
    }
    
    private function getTotalBalances($start_date, $end_date)
    {
      $sql    = "SELECT SUM(balance) AS total_balances FROM payroll WHERE created_at BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      return ($row['total_balances'] !== null) ? $row['total_balances'] : 0;
    }
    
    // Profit Report
    public function profitReport($start_date, $end_date)
    {
      $data = $this->getProfitDetails($start_date, $end_date);
    
      $report = '<p><strong>Profit Report for the period from ' . $start_date . ' to ' . $end_date . ':</strong></p>';
      $report .= '<div class="row">';
    
      // First column - total revenue, total expenses, net profit, and profit percentage
      $report .= '<div class="col-md-6">';
      $report .= '<p>Total Revenue: ' . CURRENCY . ' ' . number_format($data['total_revenue'], 2) . '</p>';
      $report .= '<p>Total Expenses: ' . CURRENCY . ' ' . number_format($data['total_expenses'], 2) . '</p>';
      $report .= '<p>Net Profit: ' . CURRENCY . ' ' . number_format($data['net_profit'], 2) . '</p>';
      $report .= '<p>Profit Percentage: ' . $data['profit_percentage'] . '%</p>';
      $report .= '</div>';
    
      // Second column - detailed table
      $report .= '<div class="col-md-6">';
      $report .= '<table class="table table-sm table-striped table-bordered">';
      $report .= '<tr><th>Date</th><th>Revenue(' . CURRENCY . ')</th><th>Expenses(' . CURRENCY . ')</th><th>Profit(' . CURRENCY . ')</th></tr>';
    
      // Fetch detailed data from profit_management table
      $sql = "SELECT date, revenue, expenses, profit FROM profit_management WHERE date BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
    
      while ($row = $result->fetch_assoc()) {
        $report .= '<tr>';
        $report .= '<td>' . $row['date'] . '</td>';
        $report .= '<td>' . number_format($row['revenue'], 2) . '</td>';
        $report .= '<td>' . number_format($row['expenses'], 2) . '</td>';
        $report .= '<td>' . number_format($row['profit'], 2) . '</td>';
        $report .= '</tr>';
      }
    
      $report .= '</table>';
      $report .= '</div>';
    
      $report .= '</div>'; // Close the row
    
      return $report;
    }
    
    private function getTotalRevenue($start_date, $end_date)
    {
      // Retrieve total revenue from the sales table
      $sql = "SELECT SUM(sale_amount) AS total_revenue FROM sales WHERE sale_date BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row = $result->fetch_assoc();
    
      return ($row && $row['total_revenue'] !== null) ? $row['total_revenue'] : 0;
    }
  
    private function getTotalExpenses($start_date, $end_date)
    {
      // Retrieve total expenses from the expenses table
      $sql = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE expense_date BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row = $result->fetch_assoc();
    
      return ($row && $row['total_expenses'] !== null) ? $row['total_expenses'] : 0;
    }
  
    private function getProfitDetails($start_date, $end_date)
    {
      $data = [];
    
      // Retrieve total revenue and total expenses from profit_management table
      $sql = "SELECT SUM(revenue) AS total_revenue, SUM(expenses) AS total_expenses FROM profit_management WHERE date BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row = $result->fetch_assoc();
    
      $data['total_revenue'] = ($row['total_revenue'] !== null) ? $row['total_revenue'] : 0;
      $data['total_expenses'] = ($row['total_expenses'] !== null) ? $row['total_expenses'] : 0;
    
      // Calculate net profit and profit percentage
      $data['net_profit'] = $data['total_revenue'] - $data['total_expenses'];
      $data['profit_percentage'] = ($data['total_revenue'] != 0) ? (($data['net_profit'] / $data['total_revenue']) * 100) : 0;
    
      return $data;
    }
  
  
  
    // Sales Report
    public function salesReport($start_date, $end_date)
    {
      $data   = [];
      $report = 'No sales report available for the selected date range.';
      
      // Retrieve total sales amount
      $totalSalesAmount = $this->getTotalSalesAmount($start_date, $end_date);
      
      if ($totalSalesAmount > 0) {
        // Retrieve the most sold item
        $mostSoldItem = $this->getMostSoldItem($start_date, $end_date);
        
        // Retrieve total sales by month
        $monthlySales = $this->getMonthlySales($start_date, $end_date);
        
        // Prepare the report
        $report = '<p>Total sales amount from <b>' . dates($start_date) . '</b> to <b>' . dates($end_date) . '</b> is <b>' . CURRENCY . ' ' . number_format($totalSalesAmount, 2) . '</b>.</p>';
        
        if ($mostSoldItem) {
          $report .= '<p>The most sold item during this period was <b>' . $this->getItemName($mostSoldItem['item_id']) . '</b> with a total quantity of <b>' . $mostSoldItem['total_quantity'] . '</b>.</p>';
        }
        
        $report .= '<table class="table table-sm table-striped table-bordered">
                        <tr>
                            <th>Month</th>
                            <th>Sales Amount('. CURRENCY .')</th>
                        </tr>';
        
        foreach ($monthlySales as $monthlySale) {
          $report .= '<tr>
                            <td>' . date('M, Y', strtotime($monthlySale['dates'])) . '</td>
                            <td>' . number_format($monthlySale['amounts'], 2) . '</td>
                        </tr>';
        }
        
        $report .= '</table>';
      }
      
      return $report;
    }
    
    private function getTotalSalesAmount($start_date, $end_date)
    {
      // Retrieve total sales amount from the database
      $sql    = "SELECT SUM(sale_amount) AS total_amount FROM sales WHERE sale_date BETWEEN ? AND ?";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      
      return ($row && $row['total_amount']) ? $row['total_amount'] : 0;
    }
    
    private function getMostSoldItem($start_date, $end_date)
    {
      // Retrieve the most sold item during the specified period
      $sql    = "SELECT item_id, SUM(quantity_sold) AS total_quantity FROM sales WHERE sale_date BETWEEN ? AND ? GROUP BY item_id ORDER BY total_quantity DESC LIMIT 1";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    private function getMonthlySales($start_date, $end_date)
    {
      // Retrieve total sales by month during the specified period
      $sql    = "SELECT SUM(sale_amount) AS amounts, LEFT(sale_date, 7) AS dates FROM sales WHERE sale_date BETWEEN ? AND ? GROUP BY dates";
      $params = [$start_date, $end_date];
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
  }