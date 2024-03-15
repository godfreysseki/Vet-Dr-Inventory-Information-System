<?php
  
  
  class Appointments extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveAppointment($data, $user_id)
    {
      if (isset($data['appointment_id']) && !empty($data['appointment_id'])) {
        return $this->updateAppointment($data, $user_id);
      } else {
        return $this->insertAppointment($data, $user_id);
      }
    }
    
    private function insertAppointment($data, $user_id)
    {
      $sql = "INSERT INTO appointments (client_id, animal_id, date_time, location, status, user_id) VALUES (?, ?, ?, ?, ?, ?)";
      $params = [
        $data['client_id'],
        $data['animal_id'],
        $data['date_time'],
        $data['location'],
        $data['status'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id,1, $insertedId, 'Added Appointment', 'Appointment inserted with ID ' . $insertedId, "Appointments", "Success");
        return json_encode(['status' => 'success', 'message' => 'Appointment record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert appointment record.']);
      }
    }
    
    private function updateAppointment($data, $user_id)
    {
      $sql = "UPDATE appointments SET client_id = ?, animal_id = ?, date_time = ?, location = ?, status=?, user_id = ? WHERE appointment_id = ?";
      $params = [
        $data['client_id'],
        $data['animal_id'],
        $data['date_time'],
        $data['location'],
        $data['status'],
        $user_id,
        $data['appointment_id']
      ];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $data['appointment_id'], 'Updated Appointment', 'Appointment updated with ID ' . $data['appointment_id'], 'Appointments', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Appointment record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No changes were made on the appointment record.']);
      }
    }
    
    public function deleteAppointment($appointment_id, $user_id)
    {
      $sql = "DELETE FROM appointments WHERE appointment_id = ?";
      $params = [$appointment_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $appointment_id, 'Deleted Appointment', 'Appointment deleted with ID ' . $appointment_id, 'Appointments', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Appointment record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Appointment Record already deleted. Reload to see the effects.']);
      }
    }
  
    public function getAllAppointments()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM appointments ORDER BY appointment_id DESC";
    
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
  
    public function displayAppointmentsTable()
    {
      $appointmentsData = $this->getAllAppointments(); // Assume you have a method to fetch all animals data
      $no = 1;
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Animal</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($appointmentsData as $appointment) {
        $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . $this->getClientName($appointment['client_id']) . '</td>
                    <td>' . $this->getAnimalName($appointment['animal_id']) . '</td>
                    <td>' . datel($appointment['date_time']) . '</td>
                    <td>' . $appointment['location'] . '</td>
                    <td>' . $appointment['status'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editAppointment" data-id="' . $appointment['appointment_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteAppointment" data-id="' . $appointment['appointment_id'] . '">Delete</button>
                    </td>
                </tr>';
        $no++;
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
    
      return $tableHtml;
    }
    
    public function getAppointmentById($appointment_id)
    {
      $sql = "SELECT * FROM appointments WHERE appointment_id = ?";
      $params = [$appointment_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayAppointmentForm($appointment_id = null)
    {
      if ($appointment_id !== null) {
        $data = $this->getAppointmentById($appointment_id);
      } else {
        $data = [
          'appointment_id' => '',
          'client_id' => '',
          'animal_id' => '',
          'date_time' => '',
          'location' => '',
          'status' => ''
          // Add more fields as needed
        ];
      }
      
      $form = '
            <form class="needs-validation" method="post" id="appointmentForm" novalidate>
                <input type="hidden" name="appointment_id" value="' . $data['appointment_id'] . '">
                
                <div class="form-group">
                    <label for="client_id">Client:</label>
                    <select class="custom-select select2" id="client_id" name="client_id" required>
                      ' . $this->getClientComboOptions($data['client_id']) . '
                    </select>
                    <div class="invalid-feedback">Please enter the client.</div>
                </div>
                
                <div class="form-group">
                    <label for="animal_id">Animal:</label>
                    <select class="custom-select select2" id="animal_id" name="animal_id" required>
                      ' . $this->getAnimalComboOptions($data['animal_id']) . '
                    </select>
                    <div class="invalid-feedback">Please enter the animal.</div>
                </div>
                
                <div class="form-group">
                    <label for="date_time">Date and Time:</label>
                    <input type="datetime-local" class="form-control" id="date_time" name="date_time" value="' . $data['date_time'] . '" required>
                    <div class="invalid-feedback">Please enter the date and time.</div>
                </div>
                
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" value="' . $data['location'] . '" required>
                    <div class="invalid-feedback">Please enter the location.</div>
                </div>
                
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="custom-select select2" id="status" name="status" required>
                      <option value="Pending" ' . (($data['status'] === 'Pending') ? 'selected' : '') . '>Pending</option>
                      <option value="Fulfilled" ' . (($data['status'] === 'Fulfilled') ? 'selected' : '') . '>Fulfilled</option>
                    </select>
                    <div class="invalid-feedback">Please select the status.</div>
                </div>
                
                <!-- Add more form fields as needed -->
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>';
      
      return $form;
    }
  
  }
