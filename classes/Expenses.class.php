<?php
  
  
  class Expenses extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveExpense($data, $user_id)
    {
      if (isset($data['expense_id']) && !empty($data['expense_id'])) {
        return $this->updateExpense($data, $user_id);
      } else {
        return $this->insertExpense($data, $user_id);
      }
    }
    
    private function insertExpense($data, $user_id)
    {
      $sql    = "INSERT INTO expenses (expense_name, amount, expense_date, user_id) VALUES (?, ?, ?, ?)";
      $params = [
        $data['expense_name'],
        $data['amount'],
        $data['expense_date'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added an expense', 'Expense inserted with ID ' . $insertedId, 'Expenses', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Expense record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert expense record.']);
      }
    }
    
    private function updateExpense($data, $user_id)
    {
      $sql    = "UPDATE expenses SET expense_name = ?, amount = ?, expense_date = ?, user_id = ? WHERE expense_id = ?";
      $params = [
        $data['expense_name'],
        $data['amount'],
        $data['expense_date'],
        $user_id,
        $data['expense_id']
      ];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $data['expense_id'], 'Updated Expense', 'Expense updated with ID ' . $data['expense_id'], 'Expenses', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Expense record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No changes made to the record.']);
      }
    }
    
    public function deleteExpense($expense_id, $user_id)
    {
      $sql    = "DELETE FROM expenses WHERE expense_id = ?";
      $params = [$expense_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $expense_id, 'Deleted Expense', 'Expense deleted with ID ' . $expense_id, 'Expenses', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Expense record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Expense record already deleted from the system. Reload to see effect.']);
      }
    }
  
    public function getAllExpenses()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM expenses";
    
      // Execute the query and fetch the results
      $result = $this->selectQuery($sql);
    
      // Initialize an array to store the fetched data
      $animalsData = [];
    
      // Fetch each row as an associative array
      while ($row = $result->fetch_assoc()) {
        $animalsData[] = $row;
      }
    
      return $animalsData;
    }
  
    public function displayExpensesTable()
    {
      $expensesData = $this->getAllExpenses(); // Assume you have a method to fetch all animals data
    
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Expense</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($expensesData as $expense) {
        $tableHtml .= '
                <tr>
                    <td>' . $expense['expense_id'] . '</td>
                    <td>' . $expense['expense_name'] . '</td>
                    <td>' . number_format($expense['amount']) . '</td>
                    <td>' . $expense['expense_date'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editExpense" data-id="' . $expense['expense_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteExpense" data-id="' . $expense['expense_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
    
      return $tableHtml;
    }
    
    public function getExpenseById($expense_id)
    {
      $sql    = "SELECT * FROM expenses WHERE expense_id = ?";
      $params = [$expense_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
  
    public function displayExpenseForm($expense_id = null)
    {
      if ($expense_id !== null) {
        $data = $this->getExpenseById($expense_id);
      } else {
        $data = [
          'expense_id' => '',
          'expense_name' => '',
          'amount' => '',
          'expense_date' => ''
          // Add more fields as needed
        ];
      }
    
      $form = '
            <form class="needs-validation" method="post" id="expenseForm" novalidate>
                <input type="hidden" name="expense_id" value="' . $data['expense_id'] . '">
                
                <div class="form-group">
                    <label for="expense_name">Expense Name:</label>
                    <input type="text" class="form-control" id="expense_name" name="expense_name" value="' . $data['expense_name'] . '" required>
                    <div class="invalid-feedback">Please enter the expense name.</div>
                </div>
                
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="' . $data['amount'] . '" required>
                    <div class="invalid-feedback">Please enter the amount.</div>
                </div>
                
                <div class="form-group">
                    <label for="expense_date">Expense Date:</label>
                    <input type="date" class="form-control" id="expense_date" name="expense_date" value="' . $data['expense_date'] . '" required>
                    <div class="invalid-feedback">Please enter the expense date.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>';
    
      return $form;
    }
  }
