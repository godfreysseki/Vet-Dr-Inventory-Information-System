<?php
  
  
  class MedicalRecords extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveMedicalRecord($data, $user_id)
    {
      if (isset($data['record_id']) && !empty($data['record_id'])) {
        return $this->updateMedicalRecord($data, $user_id);
      } else {
        return $this->insertMedicalRecord($data, $user_id);
      }
    }
    
    private function insertMedicalRecord($data, $user_id)
    {
      $sql = "INSERT INTO medical_records (animal_id, date_visited, vaccination_status, treatments, prescriptions, user_id) VALUES (?, ?, ?, ?, ?, ?)";
      $params = [
        $data['animal_id'],
        $data['date_visited'],
        $data['vaccination_status'],
        $data['treatments'],
        $data['prescriptions'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added medical record', 'Medical record inserted with ID ' . $insertedId, 'Medical Records', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Medical record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert medical record.']);
      }
    }
    
    private function updateMedicalRecord($data, $user_id)
    {
      $sql = "UPDATE medical_records SET animal_id = ?, date_visited = ?, vaccination_status = ?, treatments = ?, prescriptions = ?, user_id = ? WHERE record_id = ?";
      $params = [
        $data['animal_id'],
        $data['date_visited'],
        $data['vaccination_status'],
        $data['treatments'],
        $data['prescriptions'],
        $user_id,
        $data['record_id']
      ];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $data['record_id'], 'Updated medical Record', 'Medical record updated with ID ' . $data['record_id'], 'Medical Records', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Medical record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No changes were mad eon the medical record.']);
      }
    }
    
    public function deleteMedicalRecord($record_id, $user_id)
    {
      $sql = "DELETE FROM medical_records WHERE record_id = ?";
      $params = [$record_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $record_id, 'Deleted Medical Record', 'Medical record deleted with ID ' . $record_id, 'Medical Records', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Medical record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Medical Record already deleted. Reload Page to see effect.']);
      }
    }
  
    public function getAllMedicalRecords()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM medical_records";
    
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
  
    public function displayMedicalRecordsTable()
    {
      $medicalRecordsData = $this->getAllMedicalRecords(); // Assume you have a method to fetch all animals data
    
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Animal</th>
                        <th>Date Visited</th>
                        <th>Vaccination Status</th>
                        <th>Treatments</th>
                        <th>Prescriptions</th>
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
                    <td>' . $this->getAnimalName($medicalRecord['animal_id']) . '</td>
                    <td>' . $medicalRecord['date_visited'] . '</td>
                    <td>' . $medicalRecord['vaccination_status'] . '</td>
                    <td>' . $medicalRecord['treatments'] . '</td>
                    <td>' . $medicalRecord['prescriptions'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editMedicalRecord" data-id="' . $medicalRecord['record_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteMedicalRecord" data-id="' . $medicalRecord['record_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
    
      return $tableHtml;
    }
    
    public function getMedicalRecordById($record_id)
    {
      $sql = "SELECT * FROM medical_records WHERE record_id = ?";
      $params = [$record_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayMedicalRecordForm($record_id = null)
    {
      if ($record_id !== null) {
        $data = $this->getMedicalRecordById($record_id);
      } else {
        $data = [
          'record_id' => '',
          'animal_id' => '',
          'date_visited' => '',
          'vaccination_status' => '',
          'treatments' => '',
          'prescriptions' => ''
          // Add more fields as needed
        ];
      }
      
      $form = '
        <form class="needs-validation" method="post" id="medicalRecordsForm" novalidate>
            <input type="hidden" name="record_id" value="' . $data['record_id'] . '">
            
            <div class="form-group">
                <label for="animal_id">Animal:</label>
                <select class="custom-select select2" id="animal_id" name="animal_id" required>
                  ' . $this->getAnimalComboOptions($data['animal_id']) . '
                </select>
                <div class="invalid-feedback">Please enter the animal.</div>
            </div>
            
            <div class="form-group">
                <label for="date_visited">Date Visited:</label>
                <input type="date" class="form-control" id="date_visited" name="date_visited" value="' . $data['date_visited'] . '" required>
                <div class="invalid-feedback">Please enter the date visited.</div>
            </div>
            
            <div class="form-group">
                <label for="vaccination_status">Vaccination Status:</label>
                <input type="text" class="form-control" id="vaccination_status" name="vaccination_status" value="' . $data['vaccination_status'] . '" required>
                <div class="invalid-feedback">Please enter the vaccination status.</div>
            </div>
            
            <div class="form-group">
                <label for="treatments">Treatments:</label>
                <textarea class="form-control" id="treatments" name="treatments" required>' . $data['treatments'] . '</textarea>
                <div class="invalid-feedback">Please enter the treatments.</div>
            </div>
            
            <div class="form-group">
                <label for="prescriptions">Prescriptions:</label>
                <input type="text" class="form-control" id="prescriptions" name="prescriptions" value="' . $data['prescriptions'] . '" required>
                <div class="invalid-feedback">Please enter the prescriptions.</div>
            </div>
            
            <!-- Add more form fields as needed -->
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
      
      return $form;
    }
  
  }
