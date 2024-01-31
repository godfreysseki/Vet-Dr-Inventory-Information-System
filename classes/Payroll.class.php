<?php
  
  
  class Payroll extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function generatePayroll($data, $user_id)
    {
      $salary           = $this->getUserSalary($user_id);
      $month            = $data['month'];
      $year             = $data['year'];
      $bonuses          = $data['bonus'];
      $deductions       = $data['deductions'];
      $advanced_payment = $data['advanced'];
      
      // Perform payroll generation logic here
      // Example: Calculate deductions, bonuses, etc.
      
      $total_payment = $salary + $bonuses - $deductions;
      $balance       = $total_payment - $advanced_payment;
      
      $sql    = "INSERT INTO payroll (user_id, month, year, salary, deductions, bonuses, advanced_payment, total_payment, balance, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $params = [
        $user_id,
        $month,
        $year,
        $salary,
        $deductions,
        $bonuses,
        $advanced_payment,
        $total_payment,
        $balance,
        ($balance <= 0) ? 'Paid' : 'Partial'
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added Payroll Record', 'Payroll generated for user ' . $user_id, 'Payroll', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Payroll generated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to generate payroll.']);
      }
    }
    
    private function getUserSalary($user_id)
    {
      $sql    = "SELECT salary FROM users WHERE user_id = ?";
      $params = [$user_id];
      
      $result = $this->selectQuery($sql, $params);
      
      $row = $result->fetch_assoc();
      
      return ($row) ? $row['salary'] : 0;
    }
    
    public function viewPayroll($payroll_id)
    {
      $sql    = "SELECT * FROM payroll WHERE payroll_id = ?";
      $params = [$payroll_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function updatePaymentStatus($payroll_id, $payment_status)
    {
      $sql    = "UPDATE payroll SET payment_status = ? WHERE payroll_id = ?";
      $params = [$payment_status, $payroll_id];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($_SESSION['user_id'], 2, $payroll_id, 'Updated payroll status', 'Payment status updated for payroll ID ' . $payroll_id, 'Payroll', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Payment status updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No changes were made to the record.']);
      }
    }
    
    public function getAllPayrolls()
    {
      $sql    = "SELECT * FROM payroll";
      $result = $this->selectQuery($sql);
      
      return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getPayrollsByUser($user_id)
    {
      $sql    = "SELECT * FROM payroll WHERE user_id = ?";
      $params = [$user_id];
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function generateGroupedPayrollTable()
    {
      $sql    = "SELECT user_id, SUM(total_payment) AS total_payment, SUM(balance) AS total_balance FROM payroll GROUP BY user_id";
      $result = $this->selectQuery($sql);
      
      $htmlTable = '<div class="table-responsive"><table class="table table-sm table-hover table-striped dataTable">';
      $htmlTable .= '<thead><tr><th>User</th><th>Total Payment</th><th>Total Balance</th><th>Action</th></tr></thead><tbody>';
      
      while ($row = $result->fetch_assoc()) {
        $htmlTable .= '<tr>';
        $htmlTable .= '<td>' . $row['user_id'] . '</td>';
        $htmlTable .= '<td>' . $row['total_payment'] . '</td>';
        $htmlTable .= '<td>' . $row['total_balance'] . '</td>';
        $htmlTable .= '<td>
                        <button class="btn btn-info btn-sm viewPayroll" data-id="' . $row['user_id'] . '">View</button>
                       </td>';
        $htmlTable .= '</tr>';
      }
      
      $htmlTable .= '</tbody></table></div>';
      
      return $htmlTable;
    }
    
    public function getUserPayrollTable($user_id)
    {
      $sql    = "SELECT * FROM payroll WHERE user_id = ?";
      $params = [$user_id];
      $result = $this->selectQuery($sql, $params);
      
      $htmlTable = '<div class="table-responsive"><table class="table table-sm table-hover table-striped dataTable">';
      $htmlTable .= '<thead><tr><th>Payroll ID</th><th>Month</th><th>Year</th><th>Basic Salary</th><th>Deductions</th><th>Bonus</th><th>Net Salary</th><th>Total Payment</th><th>Balance</th><th>Payment Status</th></tr></thead><tbody>';
      
      while ($row = $result->fetch_assoc()) {
        $htmlTable .= '<tr>';
        $htmlTable .= '<td>' . $row['payroll_id'] . '</td>';
        $htmlTable .= '<td>' . $row['month'] . '</td>';
        $htmlTable .= '<td>' . $row['year'] . '</td>';
        $htmlTable .= '<td>' . $row['salary'] . '</td>';
        $htmlTable .= '<td>' . $row['deductions'] . '</td>';
        $htmlTable .= '<td>' . $row['bonuses'] . '</td>';
        $htmlTable .= '<td>' . $row['advanced_payment'] . '</td>';
        $htmlTable .= '<td>' . $row['total_payment'] . '</td>';
        $htmlTable .= '<td>' . $row['balance'] . '</td>';
        $htmlTable .= '<td>' . $row['payment_status'] . '</td>';
        $htmlTable .= '</tr>';
      }
      
      $htmlTable .= '</tbody></table></div>';
      
      return $htmlTable;
    }
    
    public function deletePayroll($payroll_id, $user_id)
    {
      $sql         = "DELETE FROM payroll WHERE payroll_id = ?";
      $params      = [$payroll_id];
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $payroll_id, 'Deleted Payroll Record', 'Payroll record deleted with ID ' . $payroll_id, 'Payroll', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Payroll record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Payroll Record already deleted. Reload page to see effects.']);
      }
    }
    
    public function getPayrollById($payroll_id)
    {
      $sql    = "SELECT * FROM payroll WHERE payroll_id = ?";
      $params = [$payroll_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayPayrollForm($payroll_id = null)
    {
      if ($payroll_id !== null) {
        $data = $this->getPayrollById($payroll_id);
      } else {
        $data = [
          'payroll_id' => '',
          'user_id' => '',
          'month' => '',
          'year' => '',
          'basic_salary' => '',
          'deductions' => '',
          'advanced_payment' => '',
          'bonus' => '',
          'net_salary' => '',
        ];
      }
      
      $form = '
            <form class="needs-validation" method="post" id="payrollForm" novalidate>
                <input type="hidden" name="payroll_id" value="' . $data['payroll_id'] . '">

                <div class="form-group">
                    <label for="user_id">User:</label>
                    <select class="custom-select select2" id="user_id" name="user_id" required>
                      '.$this->getUsersComboOptions($data['user_id']).'
                    </select>
                    <div class="invalid-feedback">Please enter the user.</div>
                </div>

                <div class="form-group">
                    <label for="month">Month:</label>
                    <input type="number" min="1" max="12" class="form-control" id="month" name="month" value="' . $data['month'] . '" required>
                    <div class="invalid-feedback">Please enter the month.</div>
                </div>

                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" min="2020" class="form-control" id="year" name="year" value="' . $data['year'] . '" required>
                    <div class="invalid-feedback">Please enter the year.</div>
                </div>

                <div class="form-group">
                    <label for="basic_salary">Basic Salary:</label>
                    <input type="number" min="0" class="form-control" id="basic_salary" name="basic_salary" value="' . $data['basic_salary'] . '" required>
                    <div class="invalid-feedback">Please enter the basic salary.</div>
                </div>

                <div class="form-group">
                    <label for="deductions">Deductions:</label>
                    <input type="number" min="0" class="form-control" id="deductions" name="deductions" value="' . $data['deductions'] . '" required>
                    <div class="invalid-feedback">Please enter the deductions.</div>
                </div>

                <div class="form-group">
                    <label for="advanced">Advanced Payments:</label>
                    <input type="number" min="0" class="form-control" id="advanced" name="advanced" value="' . $data['advanced_payment'] . '" required>
                    <div class="invalid-feedback">Please enter the advanced payment.</div>
                </div>

                <div class="form-group">
                    <label for="bonus">Bonus:</label>
                    <input type="number" min="0" class="form-control" id="bonus" name="bonus" value="' . $data['bonus'] . '" required>
                    <div class="invalid-feedback">Please enter the bonus.</div>
                </div>

                <div class="form-group">
                    <label for="net_salary">Net Salary:</label>
                    <input type="number" min="0" class="form-control" id="net_salary" name="net_salary" value="' . $data['net_salary'] . '" required>
                    <div class="invalid-feedback">Please enter the net salary.</div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>';
      
      return $form;
    }
  }
