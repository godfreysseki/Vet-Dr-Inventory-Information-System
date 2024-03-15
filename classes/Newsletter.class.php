<?php
  
  
  class Newsletter extends Config
  {
    
    private $auditTrail;
  
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
  
    public function subscribe($email)
    {
      $sql = "INSERT INTO subscribers (email, created_at) VALUES (?, ?)";
      $params = [
        $data['email'],
        date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
      ];
  
      $insertedId = $this->insertQuery($sql, $params);
  
      if ($insertedId) {
        return json_encode(['status' => 'success', 'message' => 'Client record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert client record.']);
      }
    }
  
    public function deleteClient($client_id, $user_id)
    {
      $sql = "DELETE FROM clients WHERE client_id = ?";
      $params = [$client_id];
    
      $deletedRows = $this->deleteQuery($sql, $params);
    
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $deletedRows, 'Deleted Client', 'Client deleted with ID ' . $deletedRows, 'Clients', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Client record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Client Record already deleted. Reload page to view effect.']);
      }
    }
  
    public function getAllSubscribers()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM subscribers ORDER BY subscriber_id DESC";
    
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
  
    public function displayClientsTable()
    {
      $clientsData = $this->getAllSubscribers(); // Assume you have a method to fetch all animals data
      $no = 1;
  
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($clientsData as $clientsData) {
        $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . $clientsData['name'] . '</td>
                    <td>' . phone($clientsData['contact_number']) . '</td>
                    <td>' . $clientsData['address'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editClient" data-id="' . $clientsData['client_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteClient" data-id="' . $clientsData['client_id'] . '">Delete</button>
                    </td>
                </tr>';
        $no++;
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
    
      return $tableHtml;
    }
  
    public function getClientById($client_id)
    {
      $sql = "SELECT * FROM clients WHERE client_id = ?";
      $params = [$client_id];
    
      $result = $this->selectQuery($sql, $params);
    
      return $result->fetch_assoc();
    }
  
    public function displayClientForm($client_id = null)
    {
      if ($client_id !== null) {
        $data = $this->getClientById($client_id);
      } else {
        $data = [
          'client_id' => '',
          'name' => '',
          'contact_number' => '',
          'address' => ''
          // Add more fields as needed
        ];
      }
    
      $form = '
            <form class="needs-validation" method="post" id="clientForm" novalidate>
                <input type="hidden" name="client_id" value="' . $data['client_id'] . '">
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="' . $data['name'] . '" required>
                    <div class="invalid-feedback">Please enter the name.</div>
                </div>
                
                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="' . $data['contact_number'] . '" required>
                    <div class="invalid-feedback">Please enter the contact number.</div>
                </div>
                
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="' . $data['address'] . '" required>
                    <div class="invalid-feedback">Please enter the address.</div>
                </div>
                
                <!-- Add more form fields as needed -->
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>';
    
      return $form;
    }
    
  }