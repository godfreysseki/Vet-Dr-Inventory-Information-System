<?php
  
  
  class Contact extends Config
  {
    private $auditTrail;
  
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function sendContact($contactData)
    {
      $name    = $contactData['name'];
      $email   = $contactData['email'];
      $subject = $contactData['subject'];
      $message = $contactData['message'];
      
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $headers .= "From: " . $name . " <" . $email . ">\r\n"; // Specify the sender name here
      $headers .= "Reply-To: " . $email . "\r\n";
      
      // Save to database and send to the system emails
      $sql    = "INSERT INTO contacts (full_name, email, subject, message, sent_at) VALUES (?, ?, ?, ?, ?)";
      $params = [
        $name,
        $email,
        $subject,
        $message,
        date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
      ];
      if ($this->insertQuery($sql, $params)) {
        // Send to the emails too, then return OK.
        if (str_contains(COMPANYEMAIL, ", ")) {
          $emails = '';
          $nums   = explode(", ", COMPANYEMAIL);
          foreach ($nums as $num) {
            mail($num, $subject, $message, $headers);
          }
        } else {
          mail(COMPANYEMAIL, $subject, $message, $headers);
        }
        
        return "OK";
      } else {
        return "FAIL";
      }
      
      return "OK";
    }
  
    public function deleteContact($contact_id, $user_id)
    {
      $sql = "DELETE FROM contacts WHERE contact_id = ?";
      $params = [$contact_id];
    
      $deletedRows = $this->deleteQuery($sql, $params);
    
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $deletedRows, 'Deleted Contact', 'Contact deleted with ID ' . $deletedRows, 'Contacts', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Contact record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Contacct Record already deleted. Reload page to view effect.']);
      }
    }
  
    public function getAllContacts()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM contacts";
    
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
  
    public function displayContactsTable()
    {
      $clientsData = $this->getAllContacts(); // Assume you have a method to fetch all animals data
    
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Viewed</th>
                        <th>Replied</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($clientsData as $clientsData) {
        $tableHtml .= '
                <tr>
                    <td>' . $clientsData['contact_id'] . '</td>
                    <td>' . $clientsData['full_name'] . '</td>
                    <td>' . $clientsData['subject'] . '</td>
                    <td>' . $clientsData['viewed'] . '</td>
                    <td>' . $clientsData['replied'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm viewContact" data-id="' . $clientsData['contact_id'] . '">View</button>
                        <button class="btn btn-success btn-sm replyContact" data-id="' . $clientsData['contact_id'] . '">Reply</button>
                        <button class="btn btn-danger btn-sm deleteContact" data-id="' . $clientsData['contact_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
    
      return $tableHtml;
    }
  
    public function getContactById($contact_id)
    {
      $sql = "SELECT * FROM contacts WHERE contact_id = ?";
      $params = [$contact_id];
    
      $result = $this->selectQuery($sql, $params);
    
      return $result->fetch_assoc();
    }
  
    public function displayContactReplyForm($client_id = null)
    {
      if ($client_id !== null) {
        $data = $this->getContactById($client_id);
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