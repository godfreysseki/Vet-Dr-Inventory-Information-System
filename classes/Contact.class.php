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
      $sql    = "DELETE FROM contacts WHERE contact_id = ?";
      $params = [$contact_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $deletedRows, 'Deleted Contact', 'Contact deleted with ID ' . $deletedRows, 'Contacts', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Contact record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Contact Record already deleted. Reload page to view effect.']);
      }
    }
    
    public function getAllContacts()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM contacts ORDER BY contact_id DESC";
      
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
      $no          = 1;
      
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
                    <td>' . $no . '</td>
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
        $no++;
      }
      
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
      
      return $tableHtml;
    }
    
    public function getContactById($contact_id)
    {
      $sql    = "SELECT * FROM contacts WHERE contact_id = ?";
      $params = [$contact_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function viewSingleContact($contactId)
    {
      $data = '';
      $row  = $this->getContactById($contactId);
      $data = 'Sender : <b>' . $row['full_name'] . '</b><br>
                Email : <b>' . email($row['email']) . '</b><br><br>
                Subject : <b>' . $row['subject'] . '</b><br><br>
                <b>Message :</b><br>' . nl2br($row['message']) . '
              ';
      
      return $data;
    }
    
    public function displayContactReplyForm($contactId)
    {
      $row  = $this->getContactById($contactId);
      $data = '<p>Sender : <b>' . $row['full_name'] . '</b></p>
                <p>Email : <b>' . email($row['email']) . '</b></p>
                <p>Subject : <b>' . $row['subject'] . '</b></p>
                <p><b>Message :</b><br>' . $row['message'] . '</p>
                <form method="post" id="replyForm">
                  <input type="hidden" name="contactId" id="contactId" value="' . $contactId . '" class="d-none">
                  <div class="form-group">
                    <label for="reply">Reply Message</label>
                    <textarea name="reply" id="reply" class="form-control editor"></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="replyBtn" class="btn btn-' . COLOR . ' float-right">Send Reply</button>
                  </div>
                </form>';
      
      return $data;
    }
    
    public function emailReply($contactId, $message)
    {
      $sql    = "SELECT * FROM contacts WHERE contact_id=? ";
      $params = [$contactId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Show Contact information then send reply
          $to           = esc($row['email']);
          $subject = "Reply - " . $row['subject'];
          // Send email to each vendor individually
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          $headers .= "From: UgaSolutions Pharmaceuticals Ltd <" . COMPANYEMAIL . ">\r\n"; // Specify the sender name here
          $headers .= "Reply-To: info@ugasolutions.co.ug\r\n";
  
          // Format email template
          $emailTemplate = $this->formatEmailTemplate($this->fullName($to), $subject, $message);
          
          
          if (mail($to, $subject, $emailTemplate, $headers)) {
            // Update contact as Replied
            $this->updateQuery("UPDATE contacts SET replied='Yes' WHERE contact_id=? ", [$contactId]);
            alert('success', 'Email Reply sent successfully.');
          } else {
            alert('warning', 'Email Replied Failed. Check your mail server.');
          }
        }
      }
    }
  
    private function fullName($email)
    {
      $sql    = "SELECT full_name FROM contacts WHERE email=?";
      $params = [$email];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['full_name'];
    }
    
    public function formatEmailTemplate($fullName, $title, $content)
    {
      // Read the content of the template file
      $templateFilePath = "mail.php"; // Update with the actual file path
      $templateContent  = file_get_contents($templateFilePath);
      
      if ($templateContent === false) {
        // Handle the error, e.g., by logging or returning an error message
        return false;
      }
      
      // Replace placeholders with actual data
      $templateContent = str_replace("[User]", $fullName, $templateContent);
      $templateContent = str_replace("[Title]", $title, $templateContent);
      $templateContent = str_replace("[Content]", $content, $templateContent);
      
      return $templateContent;
    }
    
    public function markAsRead($contactId)
    {
      $sql    = "UPDATE contacts SET viewed='Yes' WHERE contact_id=? ";
      $params = [$contactId];
      $this->updateQuery($sql, $params);
    }
    
  }