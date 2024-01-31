<?php
  
  
  class ProfitManagement extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveProfitRecord($data, $user_id)
    {
      if (isset($data['record_id']) && !empty($data['record_id'])) {
        return $this->updateProfitRecord($data, $user_id);
      } else {
        return $this->insertProfitRecord($data, $user_id);
      }
    }
    
    private function insertProfitRecord($data, $user_id)
    {
      $sql = "INSERT INTO profit_management (date, revenue, expenses, profit, user_id) VALUES (?, ?, ?, ?, ?)";
      $params = [
        $data['date'],
        $data['revenue'],
        $data['expenses'],
        $data['profit'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added Day Earnings', 'Profit record inserted with ID ' . $insertedId, 'Profit Management', 'success');
        return json_encode(['status' => 'success', 'message' => 'Profit record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert profit record.']);
      }
    }
    
    private function updateProfitRecord($data, $user_id)
    {
      $sql = "UPDATE profit_management SET date = ?, revenue = ?, expenses = ?, profit = ?, user_id = ? WHERE record_id = ?";
      $params = [
        $data['date'],
        $data['revenue'],
        $data['expenses'],
        $data['profit'],
        $user_id,
        $data['record_id']
      ];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $data['record_id'], 'Updated Day Earnings', 'Profit record updated with ID ' . $data['record_id'], 'Profit Management', 'success');
        return json_encode(['status' => 'success', 'message' => 'Profit record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No changes were made to the record.']);
      }
    }
    
    public function deleteProfitRecord($record_id, $user_id)
    {
      $sql = "DELETE FROM profit_management WHERE record_id = ?";
      $params = [$record_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $record_id, 'Deleted Day Earnings', 'Profit record deleted with ID ' . $record_id, 'Profit Management', 'success');
        return json_encode(['status' => 'success', 'message' => 'Profit record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Earnings record already deleted. Reload to see effect.']);
      }
    }
  
    public function getAllProfitRecords()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM profit_management";
    
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
  
    public function displayProfitRecordsTable()
    {
      $medicalRecordsData = $this->getAllProfitRecords(); // Assume you have a method to fetch all animals data
    
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total Revenue</th>
                        <th>Total Costs</th>
                        <th>Net Revenue</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($medicalRecordsData as $medicalRecord) {
        $tableHtml .= '
                <tr>
                    <td>' . $medicalRecord['record_id'] . '</td>
                    <td>' . $medicalRecord['date'] . '</td>
                    <td>' . $medicalRecord['revenue'] . '</td>
                    <td>' . $medicalRecord['expenses'] . '</td>
                    <td>' . $medicalRecord['profit'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editProfitRecord" data-id="' . $medicalRecord['record_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteProfitRecord" data-id="' . $medicalRecord['record_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
    
      return $tableHtml;
    }
    
    public function getProfitRecordById($record_id)
    {
      $sql = "SELECT * FROM profit_management WHERE record_id = ?";
      $params = [$record_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayProfitRecordForm($record_id = null)
    {
      if ($record_id !== null) {
        $data = $this->getProfitRecordById($record_id);
      } else {
        $data = [
          'record_id' => '',
          'date' => '',
          'revenue' => '',
          'expenses' => '',
          'profit' => ''
          // Add more fields as needed
        ];
      }
      
      $form = '
        <form class="needs-validation" method="post" id="profitManagementForm" novalidate>
            <input type="hidden" name="record_id" value="' . $data['record_id'] . '">
            
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="' . $data['date'] . '" required>
                <div class="invalid-feedback">Please enter the date.</div>
            </div>
            
            <div class="form-group">
                <label for="revenue">Revenue:</label>
                <input type="text" class="form-control" id="revenue" name="revenue" value="' . $data['revenue'] . '" required>
                <div class="invalid-feedback">Please enter the revenue.</div>
            </div>
            
            <div class="form-group">
                <label for="expenses">Expenses:</label>
                <input type="text" class="form-control" id="expenses" name="expenses" value="' . $data['expenses'] . '" required>
                <div class="invalid-feedback">Please enter the expenses.</div>
            </div>
            
            <div class="form-group">
                <label for="profit">Profit:</label>
                <input type="text" class="form-control" id="profit" name="profit" value="' . $data['profit'] . '" required>
                <div class="invalid-feedback">Please enter the profit.</div>
            </div>
            
            <!-- Add more form fields as needed -->
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
      
      return $form;
    }
  
  }
