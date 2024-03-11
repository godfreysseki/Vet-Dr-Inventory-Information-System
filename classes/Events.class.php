<?php
  
  
  class Events extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveEvent($data, $user_id)
    {
      if (isset($data['event_id']) && !empty($data['event_id'])) {
        return $this->updateEvent($data, $user_id);
      } else {
        return $this->insertEvent($data, $user_id);
      }
    }
    
    private function insertEvent($data, $user_id)
    {
      // Handle file uploads
      $images = [];
      
      if (!empty($_FILES['images']['name'][0])) {
        $files     = $_FILES['images'];
        $uploadDir = '../assets/img/events/'; // Set the upload directory path
        
        foreach ($files['name'] as $key => $fileName) {
          $tempName    = $files['tmp_name'][$key];
          $extension   = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension
          $newFileName = 'event_' . uniqid() . '.' . $extension;  // Create a unique filename with the original extension
          $destination = $uploadDir . $newFileName;
          
          // Move the uploaded file to the desired location
          if (move_uploaded_file($tempName, $destination)) {
            $images[] = $newFileName;
          }
        }
        
      }
      
      
      $sql    = "INSERT INTO events (event_date, images, title, body, hosts, location, types, create_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $params = [
        $data['event_date'],
        implode(', ', $images), // Convert array of image filenames to a comma-separated string
        $data['title'],
        $data['body'],
        $data['hosts'],
        $data['location'],
        $data['types'],
        date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added Event', 'Event inserted with ID ' . $insertedId, 'Events', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Event record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert event record.']);
      }
    }
  
    private function updateEvent($data, $user_id)
    {
      // Handle file uploads
      $images = explode(", ", $this->getEventById($data['event_id'])['images']);
    
      if (!empty($_FILES['images']['name'][0])) {
        $files = $_FILES['images'];
        $uploadDir = '../assets/img/events/';
      
        foreach ($files['name'] as $key => $fileName) {
          $tempName = $files['tmp_name'][$key];
          $extension = pathinfo($fileName, PATHINFO_EXTENSION);
          $newFileName = 'event_' . uniqid() . '.' . $extension;
          $destination = $uploadDir . $newFileName;
        
          if (move_uploaded_file($tempName, $destination)) {
            $images[] = $newFileName;
          }
        }
      }
    
      // Prepare the SQL query for updating event data
      $sql = "UPDATE events SET event_date = ?, images = ?, title = ?, body = ?, hosts = ?, location = ?, types = ? WHERE event_id = ?";
      $params = [
        $data['event_date'],
        implode(', ', $images), // Convert array of image filenames to a comma-separated string
        $data['title'],
        $data['body'],
        $data['hosts'],
        $data['location'],
        $data['types'],
        $data['event_id']
      ];
    
      // Execute the update query
      $updatedRows = $this->updateQuery($sql, $params);
    
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $updatedRows, 'Updated Event', 'Event updated with ID ' . $updatedRows, 'Events', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Event record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to update event record.']);
      }
    }
  
    public function deleteEvent($event_id, $user_id)
    {
      $uploadDir = '../assets/img/events/';
    
      // Fetch the images associated with the event
      $sql = "SELECT images FROM events WHERE event_id = ?";
      $params = [$event_id];
      $result = $this->selectQuery($sql, $params);
    
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $images = explode(', ', $row['images']); // Assuming images are stored as comma-separated values in the database
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No event found with the provided ID.']);
      }
    
      // Delete the event from the database
      $sql = "DELETE FROM events WHERE event_id = ?";
      $deletedRows = $this->deleteQuery($sql, $params);
    
      if ($deletedRows) {
        // Log the activity
        $this->auditTrail->logActivity($user_id, 3, $deletedRows, 'Deleted Event', 'Event deleted with ID ' . $deletedRows, 'Events', 'Success');
      
        // Delete associated images
        foreach ($images as $image) {
          $filePath = $uploadDir . $image;
          if (file_exists($filePath)) {
            unlink($filePath); // Delete the file if it exists
          }
        }
      
        return json_encode(['status' => 'success', 'message' => 'Event record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Event Record could not be deleted.']);
      }
    }
  
    public function getAllEvents()
    {
      // Sample SQL query to select all events ordered by event_id in descending order
      $sql = "SELECT * FROM events ORDER BY event_id DESC";
    
      // Execute the query and fetch the results
      $result = $this->selectQuery($sql);
    
      // Initialize an array to store the fetched data
      $eventsData = [];
    
      // Fetch each row as an associative array
      while ($row = $result->fetch_assoc()) {
        $eventsData[] = $row;
      }
      
      return $eventsData;
      
    }
  
    public function displayEventsTable()
    {
      $clientsData = $this->getAllEvents(); // Assume you have a method to fetch all animals data
      
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Date</th>
                        <th>Title</th>
                        <th>Hosts</th>
                        <th>Type</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
      
      // Populate table rows with data
      foreach ($clientsData as $clientsData) {
        $tableHtml .= '
                <tr>
                    <td>' . $clientsData['event_id'] . '</td>
                    <td>' . dates($clientsData['event_date']) . '</td>
                    <td>' . $clientsData['title'] . '</td>
                    <td>' . $clientsData['hosts'] . '</td>
                    <td>' . $clientsData['types'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-success btn-sm viewEvent" data-id="' . $clientsData['event_id'] . '">View</button>
                        <button class="btn btn-info btn-sm editEvent" data-id="' . $clientsData['event_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteEvent" data-id="' . $clientsData['event_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
      
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
      
      return $tableHtml;
    }
    
    public function getEventById($client_id)
    {
      $sql    = "SELECT * FROM events WHERE event_id = ?";
      $params = [$client_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayEventForm($client_id = null)
    {
      if ($client_id !== null) {
        $data = $this->getEventById($client_id);
      } else {
        $data = [
          'event_id' => '',
          'event_date' => '',
          'images' => '',
          'title' => '',
          'body' => '',
          'hosts' => '',
          'location' => '',
          'types' => ''
        ];
      }
      
      $form = '
            <form class="needs-validation" method="post" id="eventsForm" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="event_id" value="' . $data['event_id'] . '">
                
                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" value="' . $data['event_date'] . '" required>
                    <div class="invalid-feedback">Please enter the event date.</div>
                </div>
                
                <div class="form-group">
                    <label for="images">Event Images: (' . $data['images'] . ')</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                    <div class="invalid-feedback">Please enter the event images.</div>
                </div>
                
                <div class="form-group">
                    <label for="title">Event Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="' . $data['title'] . '" required>
                    <div class="invalid-feedback">Please enter the event title.</div>
                </div>
                
                <div class="form-group">
                    <label for="body">Event Description:</label>
                    <textarea class="editor form-control" id="body" name="body" required>' . $data['body'] . '</textarea>
                    <div class="invalid-feedback">Please enter the event description.</div>
                </div>
                
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" value="' . $data['location'] . '" required>
                    <div class="invalid-feedback">Please enter the hosts.</div>
                </div>
                
                <div class="form-group">
                    <label for="hosts">Hosts(Separate with comma and space after):</label>
                    <input type="text" class="form-control" id="hosts" name="hosts" value="' . $data['hosts'] . '" placeholder="Joe Deo, Jane Deo" required>
                    <div class="invalid-feedback">Please enter the hosts.</div>
                </div>
                
                <div class="form-group">
                    <label for="types">Category:</label>
                    <select class="custom-select select2" id="types" name="types" required>
                      <option value="Event" ' . (($data['types'] === 'Event') ? "selected" : "") . '>Event</option>
                      <option value="Workshop" ' . (($data['types'] === 'Workshop') ? "selected" : "") . '>Workshop</option>
                    </select>
                    <div class="invalid-feedback">Please enter the Category.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>';
      
      return $form;
    }
    
    // Client Side
    public function displayEvents()
    {
      $data   = '';
      $events = $this->getAllEvents();
      foreach ($events as $row) {
        $data .= '<div class="col-md-6">
                    <div class="card mb-3 post-entry">
                      <div class="row g-0">
                        <div class="col-md-4 d-flex align-items-stretch post-image">
                          <img src="assets/img/events/' . explode(", ", $row['images'])[0] . '" class="img-fluid h-100 rounded-start" alt="...">
                          <p class="date-display">' . date("d", strtotime($row['event_date'])) . '<br>' . date("M", strtotime($row['event_date'])) . '<br>' . date("Y", strtotime($row['event_date'])) . '</p>
                        </div>
                        <div class="col-md-8 d-flex align-items-stretch">
                          <div class="card-body">
                            <a href="event.php?id=' . $row['event_id'] . '" class="stretched-link">
                              <h5 class="card-title">' . $row['title'] . '</h5>
                              <p class="card-text">' . reduceWords(strip_tags($row['body']), 80) . '</p>
                              <p class="card-text"><small class="text-body-secondary">By ' . $row['hosts'] . '</small></p>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
      }
      
      return $data;
    }
    
  }